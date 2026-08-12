<?php

namespace App\Services;

use App\Services\Bokun\BokunBookingService;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class BokunService
{
    private $apiService;

    public function __construct(BokunBookingService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function getPricingList($id): array
    {
        $data = $this->apiService->getTour($id);

        return Collection::make(Arr::get($data, 'pricingCategories'))
            ->map(fn($item) => [
                'id' => Arr::get($item, 'id'),
                'title' => Arr::get($item, 'title'),
                'minAge' => Arr::get($item, 'minAge'),
                'maxAge' => Arr::get($item, 'maxAge'),
            ])->toArray();
    }
}