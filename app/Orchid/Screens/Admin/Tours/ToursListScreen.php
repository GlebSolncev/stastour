<?php

namespace App\Orchid\Screens\Admin\Tours;

use Carbon\Carbon;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Screen;
use App\Models\Tours;
use App\Models\BokunImport;
use App\Jobs\ImportBokunTours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Orchid\Layouts\Admin\Tours\TourListLayout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Facades\Layout;

class ToursListScreen extends Screen
{
    public $importRunning = false;
    public $lastImportStatus = null;
    public $lastImportMessage = null;

    public function name(): ?string
    {
        return 'Tours list';
    }

    public function query(): array
    {
        $lastImport = BokunImport::latest('id')->first();
        $this->lastImportStatus = $lastImport
            ? $lastImport->created_at?->format('d.m H:i') . ' - ' . $lastImport->status
            : null;
        $this->lastImportMessage = $lastImport?->errors
            ? collect($lastImport->errors)->map(
                fn ($message, $key) => $key . ': ' . $message
            )->implode('; ')
            : __('No errors.');
        $this->importRunning = BokunImport::whereIn('status', ['running', 'in_progress'])->exists();

        return [
            'tours' => Tours::all(),
        ];
    }

    public function layout(): iterable
    {
        return [
            TourListLayout::class,
            Layout::view('admin.bokun-import-command-styles'),
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create tour'))
                ->icon('plus')
                ->href(route('tours.create')),
            Button::make(__('Import from Bokun'))
                ->icon('cloud-download')
                ->method('importFromBokun')
                ->disabled((bool) $this->importRunning)
                ->confirm(__('Import all active tours from Bokun? Existing tours will be updated.')),
            DropDown::make($this->lastImportStatus
                ? __('Last import: ') . strtoupper(str_replace('_', ' ', $this->lastImportStatus))
                : __('Last import: never'))
                ->icon((bool) $this->importRunning ? 'hourglass-split' : 'info-circle')
                ->class((bool) $this->importRunning
                    ? 'btn btn-link dropdown-toggle bokun-import-running'
                    : 'btn btn-link dropdown-toggle')
                ->list([
                    Button::make(__('Message: ') . ($this->lastImportMessage ?: __('No errors.')))
                        ->icon($this->lastImportMessage === __('No errors.') ? 'check-circle' : 'exclamation-circle')
                        ->class('dropdown-item text-wrap bokun-import-message')
                        ->disabled(true),
                ]),
        ];
    }

    public function importFromBokun()
    {
        try {
            $record = DB::transaction(function () {
                $active = BokunImport::whereIn('status', ['running', 'in_progress'])
                    ->lockForUpdate()
                    ->first();
                if ($active) return null;

                return BokunImport::create([
                    'status' => 'running',
                    'requested_by' => Auth::id(),
                ]);
            });

            if (!$record) {
                Toast::warning(__('Bokun import is already queued or running.'));
                return redirect()->route('tours.list');
            }

            ImportBokunTours::dispatch($record->id);
            Toast::info(__('Bokun import queued. The background worker will process it.'));
        } catch (\Throwable $exception) {
            report($exception);
            Toast::error(__('Unable to queue Bokun import: ') . $exception->getMessage());
        }

        return redirect()->route('tours.list');
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
        $newTour->bokun_id = null;
        $newTour->code = '';
        $newTour->name .= ' - cloned';
        $newTour->created_at = Carbon::now();
        $newTour->save();

        if($newTour->id) {
            return redirect()->route('tour.edit', ['id' => $newTour->id]);
        }
    }
}
