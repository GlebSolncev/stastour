<?php
namespace App\Orchid\Screens\Admin\News;

use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use App\Orchid\Layouts\Admin\News\NewsListLayout;
use App\Models\News;

class NewsListScreen extends Screen
{
    public function name(): ?string
    {
        return 'Blog';
    }

    public function layout(): iterable
    {
        return [
            NewsListLayout::class
        ];
    }

    public function query(Request $request): array
    {
        return [
            'news' => News::all()
        ];
    }

    public function commandBar(): iterable
    {
        return [
            Link::make(__('Create article'))
                ->icon('plus')
                ->href(route('news.create')),
        ];
    }

    public function remove(Request $request)
    {
        $id = $request->get('id');

        $news = News::find($id);

        $news->delete();
    }
}
