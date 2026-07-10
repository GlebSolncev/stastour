<?php

namespace App\Http\Controllers;

use App\Models\MainBanners;
use Orchid\Attachment\Models\Attachment;

class MainBannersController extends Controller
{
    public static function getLastBanners(int $limit = 10)
    {
        $banners = MainBanners::getLast($limit);
        $result = [];

        foreach($banners as $banner) {
            $entity = (object)[
                'image' => (object)[
                    'src' => Attachment::find($banner->image)->url()
                ],
                'title' => $banner->name,
                'description' => str_replace("\n", "<br/>", $banner->description),
                'align' => $banner->position,
                'button' => (object)[
                    'href' => '/',
                    'title' => 'Book a tour'
                ]
            ];

            if($banner->button && $banner->url) {
                $entity->button->href = $banner->url;
                $entity->button->title = $banner->button;
            }

            $result[] = $entity;
        }

        return $result;
    }
}
