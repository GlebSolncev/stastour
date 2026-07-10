<?php

namespace App\Http\Controllers;

use App\Models\Tours;
use Illuminate\Support\Str;
use Orchid\Attachment\Models\Attachment;

class TourController extends Controller
{
    public function detail(string $code)
    {

        /** @var Tours $tour */
        if ($tour = Tours::query()->where('code', '=', $code)->first()) {

            return view('page.tour', [
                'tour' => (object)[
                    'title' => $tour->name,
                    'entity' => static::getDetailData($tour)
                ],

                'similar' => SimilarTourController::get('private')
            ]);
        }

        return abort(404);
    }

    public static function getTourGallery(Tours $tour)
    {

        if ($images = $tour->image) {
            $imageIterator = Attachment::query()
                ->whereIn('id', static::getImagesIds($images))
                ->get();

            $result = [];
            foreach ($imageIterator as $image) {
                $result[] = (object)[
                    'src' => $image->url()
                ];
            }

            return (object)$result;
        }

        return null;
    }

    protected static function getImagesIds(?string $stream): array
    {
        return array_filter(explode(',', $stream), fn($entity) => is_numeric($entity));
    }

    public static function getAllToursByType(string $type)
    {
        $result = [];
        $iterator = Tours::query()
            ->select(['id', 'name'])
            ->where('type_tour', '=', $type)
            ->get();

        foreach ($iterator as $tour) {
            $result[] = (object)[
                'id' => $tour->id,
                'title' => $tour->name
            ];
        }

        return (object)$result;
    }

    public static function getTourNearbyTimeslots(Tours $tour): object
    {
        return (object)[
            (object)[
                'id' => 1,
                'title' => '10:00 - 13:00',
                'timestamp' => strtotime(date('j.m.Y') . ' 10:00:00')
            ],
            (object)[
                'id' => 2,
                'title' => '14:00 - 16:00',
                'timestamp' => strtotime(date('j.m.Y') . ' 14:00:00')
            ]
        ];
    }

    public static function getCheckoutData(Tours $tour): object
    {
        $calendar = new \App\Travel\Timeslot\Calendar($tour);

        return (object)[
            'group' => static::getAllToursByType($tour->type_tour),
            'calendar' => $calendar->calculateForCurrentMonth(),
        ];
    }

    public static function getFile(?string $source): ?string
    {
        if(isset($source)) {
            $fileId = json_decode($source)[0];
            if($file = Attachment::find($fileId)) {
                return $file->url();
            }
        }

        return null;
    }

    public static function getDetailData(Tours $tour): object
    {
        $entity = [
            'id' => $tour->id,
            'image' => (object)[
                'type' => $tour->type_tour,
                'color' => 'green',
            ],
            'detail_image' => (object)[
                'type' => $tour->type_tour,
                'src' => static::getFile($tour->detail_photo)
            ],
            'title' => $tour->name,
            'description' => $tour->preview_text,
            'detail_text' => Str::inlineMarkdown($tour->description),
            'href' => CatalogSectionController::getUrl($tour),
            'properties' => (object)[
                (object)['type' => 'price', 'label' => $tour->price . ' €'],
                (object)['type' => 'foot'],
                (object)['type' => 'duration', 'label' => $tour->duration_of_the_tour . 'h'],
                (object)['type' => 'count', 'label' => $tour->person_count . ' persons'],
                (object)['type' => 'location', 'label' => $tour->road]
            ],
            'person_count' => $tour->person_count,
            'price' => $tour->price,
            'map' => static::getFile($tour->map_file),
            'checkout' => static::getCheckoutData($tour)
        ];

        if ($gallery = static::getTourGallery($tour)) {
            $entity['gallery'] = $gallery;
        }
        return (object)$entity;
    }
}
