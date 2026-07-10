<?php

namespace App\Orchid\Screens\Admin\Stoplist;


use App\Models\MainBanners;
use App\Models\News;
use App\Models\Timeslot;
use App\Orchid\Layouts\Admin\Timeslot\TimeslotListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use App\Orchid\Layouts\Admin\Banners\Main\MainBannersListLayout;

class Stoplist extends Screen
{

    public function name(): ?string
    {
        return 'Timeslots';
    }

    public function query(Request $request): array
    {
        return [
            'timeslot' => Timeslot::all()
        ];
    }

    public function layout(): iterable
    {
        return [
            TimeslotListLayout::class
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create new Timeslot'))
                ->icon('plus')
                ->href(route('timeslot.create')),
        ];
    }

    public function remove(Request $request)
    {

        $id = $request->get('id');
        $news = Timeslot::find($id);
        $news->delete();

    }

}
