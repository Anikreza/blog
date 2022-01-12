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

    public function publishedArticles(int $categoryId, int $limit)
    {
        return $this->baseQuery($categoryId)
            ->select('id', 'title', 'slug', 'featured', 'published', 'image', 'viewed')
            ->with('favorites')
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function publishedFeaturedArticles(int $categoryId, int $limit)
    {
        return $this->baseQuery($categoryId)
            ->select('id', 'title', 'slug', 'featured', 'published', 'image', 'viewed')
            ->where('featured', 1)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function mostReadArticles(int $categoryId, int $limit)
    {
        return $this->baseQuery($categoryId)
            ->select('id', 'title', 'slug', 'featured', 'published', 'image', 'viewed')
            ->limit($limit)
            ->orderBy('viewed', 'desc')
            ->get();
    }

    public function getArticle($condition, $isSlug = false)
    {
        return $this->model->with(['categories' => function ($q) use ($condition, $isSlug) {
            $q->with(['articles' => function ($sq) use ($condition, $isSlug) {
                $sq->select('article_id', 'title', 'slug', 'published', 'viewed', 'image', 'featured', 'description')
                    ->with('favorites')
                    ->where('published', '=', true)
                    ->when($isSlug, function ($s) use ($condition, $isSlug) {
                        $s->where('slug', '!=', $condition);
                    })
                    ->when(!$isSlug, function ($s) use ($condition, $isSlug) {
                        $s->where('article_id', '!=', $condition);
                    })
                    ->inRandomOrder()
                    ->limit(4);
            }]);
        }])
            ->with(['keywords', 'favorites'])
            ->where('published', true)
            ->when($isSlug, function ($q) use ($condition) {
                $q->where('slug', $condition);
            })
            ->when(!$isSlug, function ($q) use ($condition) {
                $q->where('id', $condition);
            })
            ->first();
    }

    public function getSimilarArticles($categoryId, $limit)
    {
        return $this->baseQuery($categoryId)
            ->select('id', 'title', 'slug', 'published', 'viewed', 'image', 'featured')
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }
}
