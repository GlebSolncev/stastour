<?php

namespace App\Services\Bokun;

class StoreBookingDto
{
    public function __construct(
        public readonly int $activityId,
        public readonly string $date, // YYYY-MM-DD
        public readonly int $startTimeId, // ID времени начала тура из календаря
        public readonly int $pricingCategoryId, // ID категории билета (например, Adult)
        public readonly int $quantity,
        public readonly array $customerInfo
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            activityId: (int)$data['activity_id'],
            date: $data['date'],
            startTimeId: (int)$data['start_time_id'],
            pricingCategoryId: (int)$data['pricing_category_id'],
            quantity: (int)$data['quantity'],
            customerInfo: $data['customer']
        );
    }
}