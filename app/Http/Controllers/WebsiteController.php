<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Repositories\Article\ArticleRepository;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */

    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
        $categories = Category::select('name', 'slug')->where('is_published', 0)->orderBy('position', 'asc')->pluck('name', 'slug');
        view()->share('categories', $categories);
    }

    public function index()
    {
        $publishedArticles = $this->articleRepository->publishedArticles(1, 4);
        $featuredArticles = $this->articleRepository->publishedFeaturedArticles(1, 3);
        $mostReadArticles = $this->articleRepository->mostReadArticles(1, 3);

        return view('pages.home.index',
            compact(
                'publishedArticles',
                'featuredArticles',
                'mostReadArticles'
            )
        );
    }

    public function articleDetails($slug)
    {
        $article = $this->articleRepository->getArticle($slug, true);
        $category = $article['categories'][0];
        $similarArticles = $this->articleRepository->getSimilarArticles($category['id'], 2);

        $cacheKey = request()->ip() . $slug;
        \Cache::remember($cacheKey, 60, function () use ($article) {
            $article->viewed = $article->viewed + 1;
            $article->save();
            return true;
        });

        return view('pages.articleDetail.index', compact('article','similarArticles','category'));
    }
    public function categoryDetails($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $segments = [
            [
                'name' => "{$category->name}",
                'url' => route('category', ['slug' => $category->slug])
            ],
        ];
        $categoryArticles = $this->articleRepository->paginateByCategoryWithFilter(5, $category->id);

        return view('pages.category.index', compact('segments', 'category','categoryArticles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
