<?php

namespace App\Http\Controllers\Tour;

use App\Services\Bokun\BokunBookingService;

class PricingCategoryTourController
{
    public function getList($id, BokunBookingService $apiService)
    {
        dd(
            $apiService->getTour($id)
        );
    }
}