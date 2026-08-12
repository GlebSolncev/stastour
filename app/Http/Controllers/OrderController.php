<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Order;
use App\Travel\Form\OrderForm;
use App\Services\Bokun\BokunBookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController
{
    public function register(Request $request, BokunBookingService $bokun)
    {
        $basketItems = BasketController::getSessionBasketItems();

        if (!$basketItems || !count($basketItems->items)) {
            return redirect()->route('mainpage');
        }

        $tourItem = null;
        foreach ($basketItems->items as $basketItem) {
            if ($basketItem->is_tour) {
                $tourItem = $basketItem;
            }
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'restrictions' => ['nullable', 'string', 'max:1000'],
            'comments' => ['nullable', 'string', 'max:2000'],
            'pickup_place_description' => ['nullable', 'string', 'max:1000'],
            'dropoff_place_description' => ['nullable', 'string', 'max:1000'],
            'passengers' => ['nullable', 'array'],
            'passengers.*.pricing_category_id' => ['required', 'integer'],
            'passengers.*.first_name' => ['required', 'string', 'max:255'],
            'passengers.*.last_name' => ['required', 'string', 'max:255'],
            'passengers.*.email' => ['required', 'email', 'max:255'],
            'passengers.*.date_of_birth' => ['required', 'date_format:Y-m-d', 'before:today'],
        ]);

        $form = OrderForm::fromRequest();

        $order = new Order($form->toArray());

        if ($tourItem) {
            $order['timeslot_id'] = $tourItem->properties['timeslot_id'];
            $order['timeslot_date'] = $tourItem->properties['timeslot_date'];
            $order['timeslot_count'] = $tourItem->quantity;
        }

        $basket = Basket::loadBasket();
        $basketItem = $basket->items()->where('is_tour', true)->first();
        $properties = $basketItem ? BasketController::getProperties($basketItem) : [];
        $isBokun = !empty($properties['bokun_id']);

        if ($isBokun) {
            $request->validate([
                'pickup_place_description' => ['required', 'string', 'max:1000'],
                'dropoff_place_description' => ['required', 'string', 'max:1000'],
            ]);

            $order->amount = (float) $properties['bokun_total'];
            $order->currency = $properties['bokun_currency'] ?? 'EUR';
            $order->status = 'creating_reservation';
            $order->bokun_status = 'creating';
        } else {
            $order->amount = (float) $basketItems->total;
            $order->currency = 'EUR';
            $order->status = 'awaiting_payment';
            $order->bokun_status = null;
        }

        $order->save();

        $basket->order_id = $order->id;
        $basket->save();

        if ($isBokun) {
            $pricing = json_decode($properties['bokun_pricing'], true, 512, JSON_THROW_ON_ERROR);
            $passengers = [];
            foreach ($validated['passengers'] ?? [] as $passenger) {
                $passengers[] = [
                    'pricingCategoryId' => (int) $passenger['pricing_category_id'],
                    'passengerDetails' => [
                        ['questionId' => 'firstName', 'values' => [$passenger['first_name']]],
                        ['questionId' => 'lastName', 'values' => [$passenger['last_name']]],
                        ['questionId' => 'email', 'values' => [$passenger['email']]],
                        ['questionId' => 'language', 'values' => ['en']],
                        ['questionId' => 'dateOfBirth', 'values' => [$passenger['date_of_birth']]],
                    ],
                ];
            }

            if (count($passengers) !== array_sum($pricing)) {
                return response()->json(['done' => false, 'message' => 'Passenger details are incomplete.'], 422);
            }

            $nameParts = preg_split('/\s+/', trim($validated['name']), 2);
            $phone = preg_replace('/(?!^\+)[^0-9]/', '', trim($validated['phone']));
            if (!str_starts_with($phone, '+')) {
                $phone = '+' . ltrim($phone, '+');
            }
            $bookingDetails = [
                'phone' => $phone,
                'restrictions' => $validated['restrictions'] ?? '',
                'pickup_place_description' => $validated['pickup_place_description'],
                'dropoff_place_description' => $validated['dropoff_place_description'],
                'comments' => $validated['comments'] ?? '',
                'passengers' => array_values($validated['passengers'] ?? []),
            ];
            $order->update(['booking_details' => $bookingDetails]);

            $bookingNote = $this->bookingNote($bookingDetails);
            $directBooking = [
                'activityBookings' => [[
                    'activityId' => (int) $properties['bokun_id'],
                    'date' => $properties['timeslot_date'],
                    'startTimeId' => (int) $properties['timeslot_id'],
                    'passengers' => $passengers,
                    'note' => $bookingNote,
                    'pickupAnswers' => [[
                        'questionId' => 'pickupPlaceDescription',
                        'values' => [$validated['pickup_place_description']],
                    ]],
                    'dropoffAnswers' => [[
                        'questionId' => 'dropoffPlaceDescription',
                        'values' => [$validated['dropoff_place_description']],
                    ]],
                ]],
                'mainContactDetails' => [
                    ['questionId' => 'firstName', 'values' => [$nameParts[0]]],
                    ['questionId' => 'lastName', 'values' => [$nameParts[1] ?? '-']],
                    ['questionId' => 'email', 'values' => [$validated['email']]],
                    ['questionId' => 'phoneNumber', 'values' => [$phone]],
                    ['questionId' => 'language', 'values' => ['en']],
                ],
                'externalBookingReference' => 'stastour-' . $order->id,
                'externalBookingEntityName' => config('app.name'),
            ];

            try {
                $reservation = $bokun->reserveForExternalPayment($directBooking, $order->id);
                $order->update([
                    'status' => 'awaiting_payment',
                    'bokun_status' => 'reserved',
                    'bokun_booking_id' => data_get($reservation, 'booking.bookingId'),
                    'bokun_confirmation_code' => data_get($reservation, 'booking.confirmationCode'),
                    'bokun_payload' => $reservation,
                ]);

                if (!$order->bokun_confirmation_code) {
                    throw new \RuntimeException('Bokun did not return a confirmation code.');
                }

                try {
                    $bokun->syncReservationDetails($reservation, [
                        'first_name' => $nameParts[0],
                        'last_name' => $nameParts[1] ?? '-',
                        'email' => $validated['email'],
                        ...$bookingDetails,
                    ]);
                } catch (\Throwable $exception) {
                    Log::warning('Bokun reservation created but structured customer details could not be updated', [
                        'order_id' => $order->id,
                        'message' => $exception->getMessage(),
                    ]);
                }

                $basket->update(['session' => 'order_' . $order->id]);
            } catch (\Throwable $exception) {
                $order->update(['status' => 'reservation_failed', 'bokun_status' => 'failed']);
                Log::error('Unable to reserve Bokun booking', [
                    'order_id' => $order->id,
                    'message' => $exception->getMessage(),
                ]);
                $message = 'The tour could not be reserved. Please select another time.';
                $bokunError = json_decode($exception->getMessage(), true);
                $errors = data_get($bokunError, 'fields.errors', []);
                if ($errors) {
                    $details = collect($errors)->map(function (array $error) {
                        $field = $error['questionId'] ?? trim($error['path'] ?? '', '/');
                        return $field . ': ' . ($error['message'] ?? $error['reason'] ?? 'invalid');
                    })->unique()->implode('; ');
                    $message = 'Please check booking details: ' . $details;
                } elseif (!empty($bokunError['message'])) {
                    $message = $bokunError['message'];
                }

                return response()->json([
                    'done' => false,
                    'message' => $message,
                ], 422);
            }
        } else {
            $basket->update(['session' => 'order_' . $order->id]);
        }

        return [
            'done' => true,
            'data' => (object)[
                'id' => $order->id
            ]
        ];
    }

    private function bookingNote(array $details): string
    {
        $lines = [
            'Booking information:',
            'Phone: ' . ($details['phone'] ?: '-'),
            'Mobility restrictions: ' . ($details['restrictions'] ?: '-'),
            'Pickup location: ' . $details['pickup_place_description'],
            'Drop-off location: ' . $details['dropoff_place_description'],
            'Comments: ' . ($details['comments'] ?: '-'),
            'Passengers:',
        ];

        foreach ($details['passengers'] as $index => $passenger) {
            $lines[] = sprintf(
                '%d. %s %s; email: %s; date of birth: %s',
                $index + 1,
                $passenger['first_name'],
                $passenger['last_name'],
                $passenger['email'],
                $passenger['date_of_birth']
            );
        }

        return implode("\n", $lines);
    }
}
