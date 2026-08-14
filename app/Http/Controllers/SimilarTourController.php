<?php

namespace App\Http\Controllers;

use App\Models\Tours;

class SimilarTourController extends Controller
{
    public static function get(string $type, int $limit = 9)
    {
        return static::mock($type, $limit);
    }

    public static function mock(string $type, int $limit)
    {
        $tours = Tours::inRandomOrder()
            ->active()
            ->where('type_tour', '=', $type)
            ->limit($limit)
            ->get();

        $result = [];

        /** @var Tours $tour */
        foreach($tours as $tour) {
            $result[] = CatalogSectionController::getPreviewData($tour);
        }

        return (object)$result;
    }
}
