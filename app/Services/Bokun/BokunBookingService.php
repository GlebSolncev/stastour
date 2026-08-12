<?php

namespace App\Services\Bokun;

use App\DTOs\StoreBookingDto;
use Exception;

class BokunBookingService
{
    public function __construct(
        private readonly BokunApiClient $apiClient
    ) {}


    public function shoppingCart(int $id, $date, array $startTimeId, array $pricingCategoryBookings)
    {
//        $sessionId = session()->getId();

        $activities = [];
        $error = [];
        foreach($startTimeId as $startTime) {
            try {
                $activities[] = $this->apiClient->request('POST', "/checkout.json/options/booking-request", [
                    'activityBookings' => [
                        [
                            'activityId' => $id,
                            'date' => $date,
                            'startTimeId' => $startTime,
                            'passengers' => $pricingCategoryBookings,
                        ]
                    ]
                ]);
            }catch (\Throwable $exception) {
                $error[] = $startTime;
            }
//            $activities[] = $this->apiClient->request('POST', "/checkout.json/options/booking-request", [
//                'activityBookings' => [
//                    [
//                        'activityId' => $id,
//                        'date' => $date,
//                        'startTimeId' => $startTime,
//                        'passengers' => $pricingCategoryBookings,
//                    ]
//                ]
//            ]);
        }

        return [
            $activities,
            $error
        ];

//        return $this->apiClient->request('POST', "/checkout.json/options/booking-request", [
//            'activityBookings' => $activities
//        ]);
    }

    public function reserveForExternalPayment(array $directBooking, int $orderId): array
    {
        $optionsResponse = $this->apiClient->request(
            'POST',
            '/checkout.json/options/booking-request',
            $directBooking
        );

        $option = collect($optionsResponse['options'] ?? [])->first(function (array $option) {
            return in_array(
                'RESERVE_FOR_EXTERNAL_PAYMENT',
                data_get($option, 'paymentMethods.allowedMethods', []),
                true
            );
        });

        if (!$option) {
            throw new Exception('Bokun channel does not allow RESERVE_FOR_EXTERNAL_PAYMENT.');
        }

        return $this->apiClient->request('POST', '/checkout.json/submit', [
            'checkoutOption' => $option['type'],
            'paymentMethod' => 'RESERVE_FOR_EXTERNAL_PAYMENT',
            'source' => 'DIRECT_REQUEST',
            'directBooking' => $directBooking,
            'uti' => data_get($option, 'paymentMethods.uti'),
            'sendNotificationToMainContact' => false,
            'showPricesInNotification' => false,
        ]);
    }

    public function confirmReserved(string $confirmationCode, float $amount, string $currency, string $transactionId): array
    {
        return $this->apiClient->request(
            'POST',
            '/checkout.json/confirm-reserved/' . rawurlencode($confirmationCode),
            [
                'amount' => $amount,
                'currency' => $currency,
                'transactionDetails' => [
                    'transactionDate' => gmdate('Y-m-d H:i:s'),
                    'transactionId' => $transactionId,
                ],
            ]
        );
    }

    public function abortReserved(string $confirmationCode): array
    {
        return $this->apiClient->request(
            'POST',
            '/booking.json/' . rawurlencode($confirmationCode) . '/abort-reserved',
            []
        );
    }

    public function syncReservationDetails(array $reservation, array $details): void
    {
        $confirmationCode = (string) data_get($reservation, 'booking.confirmationCode');
        if ($confirmationCode === '') {
            throw new Exception('Bokun reservation has no confirmation code.');
        }

        $this->apiClient->request(
            'POST',
            '/booking.json/update-customer/' . rawurlencode($confirmationCode),
            [
                'firstName' => $details['first_name'],
                'lastName' => $details['last_name'],
                'email' => $details['email'],
                'phoneNumber' => $details['phone'],
            ]
        );

        $activityBookingId = data_get($reservation, 'booking.activityBookings.0.bookingId');
        $pricingBookings = data_get($reservation, 'booking.activityBookings.0.pricingCategoryBookings', []);
        if (!$activityBookingId || !$pricingBookings) {
            return;
        }

        $actions = [];
        foreach (array_values($details['passengers'] ?? []) as $index => $passenger) {
            $pricingBookingId = data_get($pricingBookings, $index . '.id');
            if (!$pricingBookingId) {
                continue;
            }

            $actions[] = [
                'type' => 'EditParticipantAction',
                'activityBookingId' => (int) $activityBookingId,
                'pricingCategoryBookingId' => (int) $pricingBookingId,
                'pricingCategoryBooking' => [
                    'passengerInfo' => [
                        'firstName' => $passenger['first_name'],
                        'lastName' => $passenger['last_name'],
                        'email' => $passenger['email'],
                        'dateOfBirth' => $passenger['date_of_birth'],
                    ],
                ],
            ];
        }

        if ($actions) {
            $this->apiClient->request('POST', '/booking.json/edit', $actions);
        }
    }



    public function getCheckout(int $id, $date, int $startTimeId){
        return $this->apiClient->request('POST', "/checkout.json/options/booking-request", [
//            'directBooking' => [
            'activityBookings' => [
                [
                    'activityId' => $id,
                    'date' => $date,
                    'startTimeId' => $startTimeId,
                    'passengers' => [
                        [
                            'pricingCategoryId' => 1083344,
                            'groupSize' => 1
                        ]
                    ],
//                        'pricingCategoryBookings' => [
//                            [
//                                'pricingCategoryId' => 1083344,
//                                'extras' => []
//                            ],
//                            [
//                                'pricingCategoryId' => 1083344,
//                                'extras' => []
//                            ],
//                        ]
                ]
            ]
//            ]
        ]);
    }

    public function getTourIds()
    {
        return $this->apiClient->request('GET', '/activity.json/active-ids', []);
    }


    public function getTour($id)
    {
        return $this->apiClient->request('GET', '/activity.json/' . $id, []);
    }

    public function getCat($id=858806, $type = 'ALL')
    {
        return $this->apiClient->request('GET', '/restapi/v2.0/experience/'.$id.'/components', [
            'componentType' => $type
        ]);
    }

    public function getPriceInfo($id)
    {
        return $this->apiClient->request('GET', '/restapi/v2.0/pricing/category/' . $id, []);
    }

    public function getSchedule($id)
    {
        return $this->apiClient->request('GET', '/restapi/v2.0/pricing/schedule/' . $id, []);
    }

    public function getAvailabl($id, $from, $to)
    {
        return $this->apiClient->request('GET', '/restapi/v2.0/availability/' . $id, [
            'from' => $from ?? '2026-07-15',
            'to' => $to ?? '2026-07-15'
        ]);
    }

    public function getAvailabilities(array $tourIds)
    {
        return $this->apiClient->request('GET', '/activity.json/list-by-id', ['ids' => implode(',', $tourIds)]);
    }

    public function getPriceList($id)
    {
        return $this->apiClient->request('GET', '/activity.json/'.$id.'/price-list', []);
    }



    public function getPrice($id, $from, $to)
    {
        return $this->apiClient->request('GET', "/activity.json/{$id}/availabilities", [
            'start' => $from ?? '2026-07-01',
            'end'   => $to ?? '2026-07-31',
//            'includeSoldOut' => true
        ]);
    }


    public function getPrices(){
        return $this->apiClient->request('GET', "/activity.json/858806/availabilities", [
            'start' => '2026-07-01',
            'end'   => '2026-07-10',
        ]);
    }

    public function getAva($id, $date)
    {
        $response = $this->apiClient->request(
            'GET',
            "/activity.json/{$id}/availabilities",
            [
                'start'           => $date,//'2026-07-02',
                'end'             => $date,//'2026-07-02',
                'lang'            => 'EN',
                'currency'        => 'EUR',
                'includeSoldOut'  => 'false'
            ]
        );

        return $response;
    }


    public function storSimpleBook($id, $startTimeId, $priceCategoryId)
    {
//        $payload = [
//            // Данные покупателя
//            'customer' => [
//                'firstName'   => 'test',//$data['customer']['first_name'],
//                'lastName'    => 'test',//$data['customer']['last_name'],
//                'email'       => 'test@gmail.com',//$data['customer']['email'],
//                'phoneNumber' => null,
//            ],
//            // Параметры бронирования активности
//            'activityId'   => $id,
//            'date'         => '2026-07-02', // Строка формата YYYY-MM-DD
//            'startTimeId'  => $startTimeId, // Например: 4439816
//
//            // В v1 категории цен передаются в массиве passengerBookings
//            'passengerBookings' => [
//                [
//                    'pricingCategoryId' => $priceCategoryId, // Например: 1083344
//                    'quantity'          => 1
//                ]
//            ],
//
//            // Опциональные флаги (зависит от настроек вашего контракта в Bókun)
//            'paymentOption' => 'ENTER_FORM_OR_UPON_ARRIVAL',
//        ];

        $payload = [
            // 1. Основные параметры активности
            'activityRequest' => [
                'activityId'  => $id,
                'rateId'      => 2064101,
                'date'        => '2026-07-02',         // Формат: YYYY-MM-DD
                'startTimeId' => $startTimeId,

                // Трансфер (опционально)
                'pickup'                 => false,
                'pickupPlaceDescription' => null,
                'dropoff'                => null,

                // Разбивка билетов по категориям
                'pricingCategoryBookings' => [
                    [
                        'pricingCategoryId' => $priceCategoryId,
                        // В этой схеме unitCount передается внутри вложенного объекта,
                        // но для базовой инициализации достаточно указать ID категории
                    ]
                ]
            ],

            // 2. Данные покупателя (Объект customer на верхнем уровне схемы)
            'customer' => [
                'firstName'   => 'test',
                'lastName'    => 'test',
                'email'       => 'test@gmail.com',
                'phoneNumber' => null,
                'country'     => $data['customer']['country'] ?? 'PT', // Рекомендуется передавать ISO код
            ],

            // 3. Параметры оплаты (Так как вы делаете бронь через API, ставим "оплата на месте/офлайн")
            'paymentOption'            => 'ENTER_FORM_OR_UPON_ARRIVAL',
            'sendCustomerNotification' => (bool) ($data['send_notification'] ?? true),
        ];

        // Очищаем payload от null-значений, чтобы избежать 400 Bad Request
        $cleanPayload = array_filter($payload, fn($value) => !is_null($value));

        // Отправляем прямой запрос. Подпись HmacSHA1 сгенерируется автоматически.
        return $this->apiClient->request(
            'POST',
            '/booking.json/activity-booking/reserve-and-confirm',
            $payload
        );
    }

    public function store(array $data): array
    {
        // 1. Шаг первый: Добавление в корзину (Резервирование мест)
        $cartPayload = [
            'activityId' => (int) $data['activity_id'],
            'date'       => $data['date'], // Формат: YYYY-MM-DD
            'startTimeId' => (int) $data['start_time_id'],
            'pricingCategoryBookings' => [
                [
                    'pricingCategoryId' => (int) $data['pricing_category_id'],
                    'quantity'          => (int) $data['quantity']
                ]
            ]
        ];

        $cartResponse = $this->apiClient->request('POST', '/cart.json/addActivity', $cartPayload);

        $cartUuid = $cartResponse['cartUuid'] ?? null;

        if (!$cartUuid) {
            throw new Exception("Bokun Cart allocation failed: " . json_encode($cartResponse));
        }

        // 2. Шаг второй: Финальный Checkout для зарезервированной корзины
        $checkoutPayload = [
            'customer' => [
                'firstName'   => $data['customer']['first_name'],
                'lastName'    => $data['customer']['last_name'],
                'email'       => $data['customer']['email'],
                'phoneNumber' => $data['customer']['phone'] ?? null,
            ]
        ];

        return $this->apiClient->request('POST', "/cart.json/{$cartUuid}/checkout", $checkoutPayload);
    }

    /**
     * Полный цикл оформления бронирования через корзину v1
     */
    public function processBooking(StoreBookingDto $dto): array
    {


//        $dto = StoreBookingDto::fromRequest([
//            'activity_id'         => 858806,
//            'date'                => '',
//            'start_time_id'       => '',
//            'pricing_category_id' => '',
//            'quantity'            => '',
//            'customer.first_name' => '',
//            'customer.last_name'  => '',
//            'customer.email'      => '',
//            'customer.phone'      => '',
//        ]);


//        $cartPayload = [
//            'activityId' => $dto->activityId,
//            'date' => $dto->date,
//            'startTimeId' => $dto->startTimeId,
//            'pricingCategoryBookings' => [
//                [
//                    'pricingCategoryId' => $dto->pricingCategoryId,
//                    'quantity' => $dto->quantity
//                ]
//            ]
//        ];

        $cartPayload = [
            'activityId' => 858806,
            'date' => '2026-07-10',
            'startTimeId' => '08:00',
            'pricingCategoryBookings' => [
                [
                    'pricingCategoryId' => $dto->pricingCategoryId,
                    'quantity' => 1
                ]
            ]
        ];

        $cartResponse = $this->apiClient->request('POST', '/cart.json/addActivity', $cartPayload);

        $cartUuid = $cartResponse['cartUuid'] ?? null;
        if (!$cartUuid) {
            throw new Exception("Failed to obtain cartUuid from Bokun.");
        }

        // Шаг 2: Выполняем Checkout для созданной корзины
        $checkoutPayload = [
            'customer' => [
                'firstName'   => 'test',
                'lastName'    => 'test',
                'email'       => 'test',
                'phoneNumber' => null,
            ]
        ];

        return $this->apiClient->request('POST', "/cart.json/{$cartUuid}/checkout", $checkoutPayload);
    }
}
