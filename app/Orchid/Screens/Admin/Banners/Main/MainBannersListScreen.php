<?php

namespace App\Orchid\Screens\Admin\Banners\Main;


use App\Models\MainBanners;
use App\Models\News;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use App\Orchid\Layouts\Admin\Banners\Main\MainBannersListLayout;

class MainBannersListScreen extends Screen
{

    public function name(): ?string
    {
        return 'Main banners list';
    }

    public function query(Request $request): array
    {
        return [
            'main_banners' => MainBanners::all()
        ];
    }

    public function layout(): iterable
    {
        return [
            MainBannersListLayout::class
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create banner'))
                ->icon('plus')
                ->href(route('main.banners.create')),
        ];
    }

    public function remove(Request $request)
    {
        $id = $request->get('id');
        $news = MainBanners::find($id);
        $news->delete();
    }

}
