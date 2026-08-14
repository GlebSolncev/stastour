<?php

namespace App\Http\Controllers;

use App\Models\Tours;

class CatalogSectionController extends Controller
{
    const GROUP = 'group';
    const PRIVATE = 'private';
    const PAGE_COUNT = 6;

    private static function allowedFilter(string $filter)
    {
        return in_array($filter, [static::GROUP, static::PRIVATE]);
    }

    public function fetch()
    {

        $filters = array_filter(
            explode(',', request()->get('filters')),
            fn($filter) => static::allowedFilter($filter)
        );

        $sections = [];

        foreach ($filters as $filter) {
            $sections[$filter] = static::getPage($filter);
        }

        return view('component.partial.catalog-sections', ['catalog' => (object)$sections]);

    }

    public function page(string $type)
    {
        $items = static::getPage($type, (int)request()->get('page') ?: 1);

        return view('component.partial.catalog-section', ['items' => (object)$items]);
    }

    public function getTourInfo(string $id)
    {
        if ($tour = Tours::active()->find($id)) {
            return json_encode([
                'done' => true,
                'data' => [
                    'id' => $tour->id,
                    'price' => $tour->price
                ]
            ]);
        }

        return json_encode([
            'done' => false
        ]);
    }

    public static function getPage(string $type, int $page = 1)
    {
        $tours = Tours::query()
            ->active()
            ->where('type_tour', '=', $type)
            ->orderBy('updated_at', 'desc')
            ->offset(($page - 1) * static::PAGE_COUNT)
            ->limit(6)
            ->get();

        $result = [];

        /** @var Tours $tour */
        foreach ($tours as $tour) {
            $result[] = static::getPreviewData($tour);
        }

        return (object)$result;
    }

    public static function getUrl(Tours $tour)
    {
        return '/tour/' . $tour->code . '/';
    }

    public static function getPreviewData(Tours $tour)
    {
        return (object)[
            'image' => (object)[
                'type' => $tour->type_tour,
                'color' => 'green',
                'src' => TourController::getFile($tour->preview_photo)
            ],
            'title' => $tour->name,
            'description' => $tour->preview_text,
            'href' => static::getUrl($tour),
            'properties' => (object)[
                (object)['type' => 'foot'],
                (object)['type' => 'duration', 'label' => $tour->duration_of_the_tour . 'h']
            ],
            'price' => $tour->price
        ];
    }

}
