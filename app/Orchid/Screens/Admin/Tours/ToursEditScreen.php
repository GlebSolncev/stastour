<?php

namespace App\Orchid\Screens\Admin\Tours;


use App\Models\Timeslot;
use App\Orchid\Layouts\Admin\Tours\ToursEditLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use App\Models\Tours;
use Orchid\Support\Facades\Toast;

class ToursEditScreen extends Screen
{
    public function name(): ?string
    {
        return 'Edit tour';
    }

    public function query($id): array
    {
        return [
            'tour' => Tours::find($id),
            'all_timeslots' => Timeslot::getOptions(),
            'tour_type' => [
                'private' => 'Private',
                'group' => 'Group'
            ],
            'type_road_tour' => [
                'foot' => 'Foot',
                'car' => 'Car'
            ]
        ];
    }

    public function commandBar(): array
    {
        return [
            Button::make(__('Save'))
                ->icon('check')
                ->method('save')
        ];
    }

    public function layout(): iterable
    {
        return [
            ToursEditLayout::class
        ];
    }

    public function save(Request $request)
    {
        try {
            $request->validate([
                'id' => ['required', 'integer', 'exists:tours,id'],
                'name' => ['required', 'string', 'max:255'],
                'image' => ['nullable', 'array'],
                'image.*' => ['integer'],
                'preview_photo' => ['nullable', 'array', 'max:1'],
                'preview_photo.*' => ['integer'],
                'detail_photo' => ['nullable', 'array', 'max:1'],
                'detail_photo.*' => ['integer'],
                'type_tour' => ['required', Rule::in(['private', 'group'])],
            ]);

            $tour = Tours::findOrFail($request->integer('id'));

            if ($tour->bokun_id) {
                $fields = [
                    'name' => $request->string('name')->trim()->toString(),
                    'type_tour' => $request->string('type_tour')->toString(),
                ];

                if ($request->has('image')) {
                    $existingImages = array_filter(explode(',', (string) $tour->image), 'is_numeric');
                    $submittedImages = array_filter($request->input('image', []), 'is_numeric');
                    $fields['image'] = implode(',', array_values(array_unique([
                        ...$existingImages,
                        ...$submittedImages,
                    ])));
                }

                if ($request->has('preview_photo')) {
                    $fields['preview_photo'] = json_encode(array_values($request->input('preview_photo', [])));
                }

                if ($request->has('detail_photo')) {
                    $fields['detail_photo'] = json_encode(array_values($request->input('detail_photo', [])));
                }

                $tour->update($fields);
                Toast::info(__('Bokun tour name, type and images updated.'));

                return redirect()->route('tour.edit', $tour->id);
            }

            $data = $request->all();

            if (isset($data['image'])) {
                $data['image'] = implode(',', $data['image']);
            }

            if (isset($data['time_slot'])) {
                $data['time_slot'] = implode(',', $data['time_slot']);
            }

            if (isset($data['map_file'])) {
                $data['map_file'] = json_encode($data['map_file']);
            }

            if (isset($data['preview_photo'])) {
                $data['preview_photo'] = json_encode($data['preview_photo']);
            }

            if (isset($data['detail_photo'])) {
                $data['detail_photo'] = json_encode($data['detail_photo']);
            }

            $fields = $data;
            unset($fields['id']);

            Tours::updateOrCreate(
                ['id' => $data['id']],
                $fields
            );

            Toast::info(__('Tour update'));

        } catch (\Throwable $exception) {
            Toast::error(__('Error ' . $exception->getMessage()));
        }
    }
}
