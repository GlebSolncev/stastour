<?php

namespace App\Orchid\Screens\Admin\Tours;

use Carbon\Carbon;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use App\Models\Tours;
use Illuminate\Http\Request;
use App\Orchid\Layouts\Admin\Tours\TourListLayout;

class ToursListScreen extends Screen
{
    public function name(): ?string
    {
        return 'Tours list';
    }

    public function query(): array
    {
        return [
            'tours' => Tours::all()
        ];
    }

    public function layout(): iterable
    {
        return [
            TourListLayout::class
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create tour'))
                ->icon('plus')
                ->href(route('tours.create')),
        ];
    }

    public function remove(Request $request)
    {
        $id = $request->get('id');

        $news = Tours::find($id);

        $news->delete();
    }

    public function copy(Request $request)
    {
        $id = $request->get('id');
        $tour = Tours::find($id);
        $newTour = $tour->replicate();
        $newTour->code = '';
        $newTour->name .= ' - cloned';
        $newTour->created_at = Carbon::now();
        $newTour->save();

        if($newTour->id) {
            return redirect()->route('tour.edit', ['id' => $newTour->id]);
        }
    }
}
