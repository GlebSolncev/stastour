<?php

namespace App\Orchid\Screens\Admin\Stoplist;


use App\Models\MainBanners;
use App\Models\News;
use App\Models\Timeslot;
use App\Models\TourTimeslotBlock;
use App\Orchid\Layouts\Admin\Stoplist\StoplistLayout;
use App\Orchid\Layouts\Admin\Timeslot\TimeslotListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use App\Orchid\Layouts\Admin\Banners\Main\MainBannersListLayout;

class StoplistScreen extends Screen
{

    public function name(): ?string
    {
        return 'Stop List';
    }

    public function query(Request $request): array
    {
        return [
            'stoplist' => TourTimeslotBlock::all()
        ];
    }

    public function layout(): iterable
    {
        return [
            StoplistLayout::class
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create new Stop list'))
                ->icon('plus')
                ->href(route('tour_stops.create')),
        ];
    }

    public function remove(Request $request)
    {

        $id = $request->get('id');
        $news = TourTimeslotBlock::find($id);
        $news->delete();

    }

}
