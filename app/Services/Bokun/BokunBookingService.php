<?php

namespace App\Services\Bokun;

use App\DTOs\StoreBookingDto;
use Exception;

class BokunBookingService
{
    public function __construct(
        private readonly BokunApiClient $apiClient
    ) {}

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