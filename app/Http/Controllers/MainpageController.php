<?php

namespace App\Http\Controllers;

use App\Models\Assets;

class MainpageController extends Controller
{
    public function show(BlogController $blog) {
        return view('page.main', [
            'assets' => Assets::getCollection(),
            'main_banner' => MainBannersController::getLastBanners(),
            'catalog' => (object)[
                'group' => CatalogSectionController::getPage(CatalogSectionController::GROUP),
                'private' => CatalogSectionController::getPage(CatalogSectionController::PRIVATE),
            ],
            'blog' => $blog->getMainBlogEntity()
        ]);
    }
}
