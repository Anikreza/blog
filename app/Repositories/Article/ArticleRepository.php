<?php

namespace App\Repositories\Article;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleRepository implements ArticleInterface
{

    private $model;

    public function __construct(Article $article)
    {
        $this->model = $article;
    }

    public function save(Request $request)
    {
        // TODO: Implement save() method.
    }

    public function update(Request $request, int $id)
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    public function paginateWithFilter(int $limit)
    {
        // TODO: Implement paginateWithFilter() method.
    }

    public function paginateByCategoryWithFilter(int $perPage, int $categoryId, bool $onlyVideo)
    {
        // TODO: Implement paginateByCategoryWithFilter() method.
    }

    private function baseQuery(int $categoryId = 1)
    {
        return $this->model->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('is_published', '=', 0);
            $q->when($categoryId !== 1, function ($sq) use ($categoryId) {
                $sq->where('category_id', $categoryId);
            });
        });
    }

    public function publishedFeaturedArticle(int $categoryId, int $limit)
    {
        return $this->baseQuery($categoryId)
            ->select('id', 'title', 'slug', 'featured', 'published', 'image', 'viewed')
            ->where('featured', 0)
            ->with('favorites')
            ->latest()
            ->limit($limit)
            ->get();
    }
}
