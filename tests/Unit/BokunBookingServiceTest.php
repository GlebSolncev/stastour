<?php

namespace Tests\Unit;

use App\Services\Bokun\BokunApiClient;
use App\Services\Bokun\BokunBookingService;
use Mockery;
use Tests\TestCase;

class BokunBookingServiceTest extends TestCase
{
    public function test_it_reserves_for_external_payment(): void
    {
        $client = Mockery::mock(BokunApiClient::class);
        $booking = ['activityBookings' => [['activityId' => 123]]];

        $client->shouldReceive('request')
            ->once()
            ->with('POST', '/checkout.json/options/booking-request', $booking)
            ->andReturn(['options' => [[
                'type' => 'CUSTOMER_FULL_PAYMENT',
                'paymentMethods' => [
                    'allowedMethods' => ['RESERVE_FOR_EXTERNAL_PAYMENT'],
                    'uti' => 'uti-1',
                ],
            ]]]);

        $client->shouldReceive('request')
            ->once()
            ->with('POST', '/checkout.json/submit', Mockery::on(function (array $payload) use ($booking) {
                return $payload['paymentMethod'] === 'RESERVE_FOR_EXTERNAL_PAYMENT'
                    && $payload['directBooking'] === $booking
                    && $payload['uti'] === 'uti-1';
            }))
            ->andReturn(['booking' => ['confirmationCode' => 'BK-1']]);

        $result = (new BokunBookingService($client))->reserveForExternalPayment($booking, 1);

        $this->assertSame('BK-1', $result['booking']['confirmationCode']);
    }

    public function test_it_confirms_reserved_booking_with_external_transaction(): void
    {
        $client = Mockery::mock(BokunApiClient::class);
        $client->shouldReceive('request')
            ->once()
            ->with('POST', '/checkout.json/confirm-reserved/BK-1', Mockery::on(function (array $payload) {
                return $payload['amount'] === 125.5
                    && $payload['currency'] === 'EUR'
                    && $payload['transactionDetails']['transactionId'] === 'pi_123';
            }))
            ->andReturn(['booking' => ['confirmationCode' => 'BK-1']]);

        $result = (new BokunBookingService($client))->confirmReserved('BK-1', 125.5, 'EUR', 'pi_123');

        $this->assertSame('BK-1', $result['booking']['confirmationCode']);
    }

    public function test_it_aborts_an_expired_reservation(): void
    {
        $client = Mockery::mock(BokunApiClient::class);
        $client->shouldReceive('request')
            ->once()
            ->with('POST', '/booking.json/BK-1/abort-reserved', [])
            ->andReturn(['success' => true]);

        $result = (new BokunBookingService($client))->abortReserved('BK-1');

        $this->assertTrue($result['success']);
    }

    public function test_it_syncs_customer_phone_and_passenger_birth_date(): void
    {
        $client = Mockery::mock(BokunApiClient::class);
        $reservation = ['booking' => [
            'confirmationCode' => 'BK-1',
            'activityBookings' => [[
                'bookingId' => 900,
                'pricingCategoryBookings' => [['id' => 901]],
            ]],
        ]];
        $details = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john@example.com',
            'phone' => '+351912345678',
            'passengers' => [[
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'email' => 'jane@example.com',
                'date_of_birth' => '1990-05-10',
            ]],
        ];

        $client->shouldReceive('request')
            ->once()
            ->with('POST', '/booking.json/update-customer/BK-1', Mockery::on(fn (array $payload) =>
                $payload['phoneNumber'] === '+351912345678'
            ))
            ->andReturn(['success' => true]);

        $client->shouldReceive('request')
            ->once()
            ->with('POST', '/booking.json/edit', Mockery::on(function (array $actions) {
                return $actions[0]['type'] === 'EditParticipantAction'
                    && $actions[0]['activityBookingId'] === 900
                    && $actions[0]['pricingCategoryBookingId'] === 901
                    && $actions[0]['pricingCategoryBooking']['passengerInfo']['dateOfBirth'] === '1990-05-10';
            }))
            ->andReturn(['success' => true]);

        (new BokunBookingService($client))->syncReservationDetails($reservation, $details);

        $this->addToAssertionCount(2);
    }
}
