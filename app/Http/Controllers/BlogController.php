<?php

namespace App\Http\Controllers;

use App\Models\News;
use Orchid\Attachment\Models\Attachment;

class BlogController extends Controller
{
    CONST LIMIT = 10;
    public function list()
    {
        $main = $this->getMainBlogEntity();

        return view('page.blog', [
            'main' => $main,
            'items' => $this->getPage(1, static::LIMIT, $main ? [$main->id] : []),
            'show_tour' => !BasketController::checkTourInBasket()
        ]);
    }

    public function detail(string $code)
    {
        $current = $this->findNews($code);
        return view('page.blog-detail', [
            'item' => $current,
            'items' => $this->getSimilar($current->id),
            'show_tour' => !BasketController::checkTourInBasket()
        ]);
    }

    public function page() {

        $main = $this->getMainBlogEntity();

        return view('component.partial.blog-page', [
            'items' => $this->getPage((int)request()->get('page') ?: 1, static::LIMIT, $main ? [$main->id] : [])
        ]);
    }

    /**
     * @return object
     */
    public function getMainBlogEntity(): ?object
    {

        $item = News::query()
            ->where('active', 1)
            ->orderBy('is_priority', 'desc')
            ->orderBy('sort', 'asc')
            ->orderBy('created_at', 'desc')->first();

        /** @var News $item */
        return $item ? $this->formatItem($item) : null;
    }

    private function getPage(int $page = 1, int $limit = 10, array $excludeIds = []): array
    {
        $items = [];
        $iterator = News::query()
            ->where('active', 1)
            ->orderBy('sort', 'asc')
            ->orderBy('created_at', 'desc')
            ->offset(($page - 1) * $limit)
            ->limit($limit);

        if ($excludeIds) {
            $iterator->whereNotIn('id', $excludeIds);
        }

        foreach ($iterator->get() as $item) {
            $items[] = $this->formatItem($item);
        }

        return $items;
    }

    public function getSimilar(int $id, int $limit = 2): array
    {
        $items = [];
        $iterator = News::inRandomOrder()
            ->where('active', 1)
            ->whereNot('id', $id)
            ->limit($limit);

        foreach ($iterator->get() as $item) {
            $items[] = $this->formatItem($item);
        }

        return $items;
    }

    public function findNews(string $code): object
    {
        $news = News::query()
            ->where('code', $code)->firstOrFail();

        return $this->formatItem($news);
    }

    private function formatItem(News $item)
    {
        $result = [
            'id' => $item['id'],
            'name' => $item['name'],
            'preview' => $item['preview_text'],
            'detail' => $item['detail_text'],
            'is_big' => $item['is_big'],
            'url' => url('/blog/' . $item['code'] . '/')
        ];

        if ($item['image']) {
            $attachment = Attachment::find($item['image']);

            if ($attachment) {
                $result['image'] = (object)[
                    'src' => $attachment->url()
                ];
            }
        }

        return (object)$result;
    }

}
