<?php

namespace App\Http\Controllers;
;

use App\Models\Category;

//use App\Models\Page;
use App\Models\Page;
use App\Models\PageLink;
use App\Repositories\Article\ArticleRepository;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Share;
use Str;


class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    private $articleRepository;
    private $baseSeoData;
    private $homePageSeoData;

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
        $tags = $this->articleRepository->getAllTags();
        $tagTitles=[];
        foreach ($tags as $tag)
            array_push($tagTitles,$tag->title);
        $categories = Category::select('name', 'slug')->where('is_published', 0)->orderBy('position', 'asc')->pluck('name', 'slug');
        $featuredArticles = $this->articleRepository->publishedArticles( 3);
        $this->homePageSeoData = json_decode(setting()->get('general'), true);
        $this->baseSeoData = [
            'title' => 'A travel blog site',
            'description' => 'A travel blog site',
            'keywords' => $tagTitles,

//            'image' => $this->homePageSeoData['home_page_image_url'] ?
//                Storage::disk('public')->url('settings/' . basename($this->homePageSeoData['home_page_image_url']))
//                :
//                asset('asset/logo.png'),
            'type' => 'website',
            'site' => env('APP_URL'),
            'app_name' => env('APP_NAME'),
            'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1'
        ];

        $footerPages = \Cache::remember('footer_pages', config('cache.default_ttl'), function () {
            return PageLink::where('key', 'footer_pages')->with('page:id,title,slug')->get()->toArray();
        });

        view()->share('footerPages', $footerPages);
        view()->share('categories', $categories);
        view()->share('tags', $tags);
        view()->share('featuredPosts', $featuredArticles);
    }

    public function index()
    {
        $publishedArticles = $this->articleRepository->publishedArticles( 4);
        $featuredArticles = $this->articleRepository->publishedFeaturedArticles( 3);
        $mostReadArticles = $this->articleRepository->mostReadArticles( 3);

        $this->seo($this->baseSeoData);

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
        $article = $this->articleRepository->getArticle($slug);
        if (!$article) {
            return $this->renderPage($slug);
        }
        $category = $article['categories'][0];
        $similarArticles = $this->articleRepository->getSimilarArticles( 2);
        $tags = $article->keywords;
        $tagTitles=[];
        foreach ($tags as $tag)
            array_push($tagTitles,$tag->title);
        $segments = [
            [
                'name' => $article['categories'][0]['name'],
                'url' => route('category', [
                    'slug' => $category['slug']
                ])
            ],
            ['name' => $article['title'], 'url' => url($slug)]
        ];
        $cacheKey = request()->ip() . $slug;
        \Cache::remember($cacheKey, 60, function () use ($article) {
            $article->viewed = $article->viewed + 1;
            $article->save();
            return true;
        });

        $appName = env('APP_NAME');
        $this->baseSeoData['title'] = " $article->title | $appName";
        $this->baseSeoData['keywords'] = $tagTitles;
        $this->seo($this->baseSeoData);

        $shareLinks = $this->getSeoLinksForDetailsPage($article);
        return view('pages.articleDetail.index', compact('article', 'similarArticles', 'category', 'segments','shareLinks'));
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
        $categoryArticles = $this->articleRepository->paginateByCategoryWithFilter(5);

        // SEO META INFO
//        $name = empty($category->meta_title) ? $category->name : $category->meta_title;
//        $title = request()->has('page') ? $name . " (Page " . request('page') . ')' : $name;
        $appName = env('APP_NAME');
        $this->baseSeoData['title'] = "{$appName} | {$category->name} | {$category->keywords}";
        $this->baseSeoData['description'] = "{$category->excerpt}";
        $this->baseSeoData['keywords'] = "{$category->keywords}";
        $this->seo($this->baseSeoData);

        return view('pages.category.index', compact('segments', 'category', 'categoryArticles'));
    }

    public function tagDetails($slug)
    {
        $tagDetails = $this->articleRepository->getTagInfoWithArticles($slug, 10);
        $tag = $tagDetails['tagInfo'];
        $tags = $tagDetails['tags'];
        $tagArticles = $tagDetails['articles'];

        if (!isset($tag->title)) {
            \Log::error("tag not found: " . $slug);
            abort(404);
        }

        $segments = [
            ['name' => $tag->title, 'url' => route('tag', ['slug' => Str::slug($tag->title)])],
        ];

        // SEO META INFO
        if ($tag->title == 'XYZs column') {
            $this->baseSeoData['title'] = "Demo blogsite Travel blog etc | {$this->baseSeoData['app_name']}";
            $this->baseSeoData['description'] = "here, you will find blogs describing cultures, ethnicity and politics around the world";
        } else {
            $this->baseSeoData['title'] = "{$tag->title} | {$this->baseSeoData['app_name']}";
        }

        $this->seo($this->baseSeoData);
        view()->share('tags', $tags);
        return view('pages.tag.index', compact('segments', 'tag', 'tagArticles'));
    }

    public function searchArticle(Request $request)
    {
        $searchTerm = $request->input('query');
        $searchedArticles = $this->articleRepository->searchArticles($searchTerm, 3);

        $segments = [
            ['name' => $searchTerm],
        ];

        // SEO META INFO
        $appName = env('APP_NAME');
        $this->baseSeoData['title'] = "$searchTerm - $appName";
        $this->seo($this->baseSeoData);

        return view('pages.search.index', compact('segments', 'searchTerm', 'searchedArticles'));
    }

    private function generatePageClass($title): \stdClass
    {
        $page = new \stdClass();
        $page->title = $title;
        $page->excerpt = null;
        $page->keywords = [];
        $page->image_url = null;

        return $page;
    }

    private function getSeoLinksForDetailsPage($data)
    {
        $this->baseSeoData = [
            'title' => $data->title . " | {$this->baseSeoData['app_name']}",
            'description' => count($data->keywords)? $data->excerpt : $this->baseSeoData['description'],
            'keywords' => count($data->keywords) ? implode(", ", $data->keywords->pluck('title')->toArray()) : $this->baseSeoData['keywords'],
            'image' => $data->image_url,
            'type' => 'article',
            'site' => env('APP_URL'),
            'app_name' => $this->baseSeoData['app_name'],
            'robots' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1'
        ];
        $this->seo($this->baseSeoData);

        return Share::page(url()->current(), $data->title)
            ->facebook()
            ->twitter()
            ->linkedin($data->excerpt)
            ->whatsapp()
            ->telegram()
            ->getRawLinks();
    }

    public function renderPage($slug)
    {
        $page = Page::where('slug', $slug)->with('keywords')->first();

        if (!$page) {
            abort(404);
        }

        $cacheKey = request()->ip() . $slug;
        \Cache::remember($cacheKey, 60, function () use ($page) {
            $page->viewed = $page->viewed + 1;
            $page->save();
            return true;
        });

        $segments = [
            ['name' => $page['title'], 'url' => url($slug)]
        ];

        return view('pages.pageDetails.index', compact('page', 'segments'));
    }

    public function getColumnistPage()
    {
        $page = $this->generatePageClass('Columnist');

        $segments = [
            ['name' => $page->title, 'url' => url('Columnist')]
        ];

        $shareLinks = $this->getSeoLinksForDetailsPage($page);
        return view('pages.columnist.index', compact('page', 'segments', 'shareLinks'));
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

    private function seo($data)
    {
        SEOMeta::setTitle($data['title'], false);
        SEOMeta::setDescription($data['description']);
//        SEOMeta::addMeta('name', $value = null, $name = 'name');
        SEOMeta::setKeywords($data['keywords']);
        SEOMeta::setRobots($data['robots']);
        SEOMeta::setCanonical(url()->full());

//        OpenGraph::addProperty('keywords', '$value'); // value can be string or array
        OpenGraph::setTitle($data['title']); // define title
        OpenGraph::setDescription($data['description']);  // define description

//        if ($data['image']) {
//            OpenGraph::addImage($data['image']); // add image url
//        } else {
//            OpenGraph::addImage($this->homePageSeoData['home_page_image_url']); // add image url
//        }

        OpenGraph::setUrl(url()->current()); // define url
        OpenGraph::setSiteName($data['app_name']); //define site_name

        TwitterCard::setType('summary'); // type of twitter card tag
        TwitterCard::setTitle($data['title']); // title of twitter card tag
        TwitterCard::setDescription($data['description']); // description of twitter card tag

//        if ($data['image']) {
//            TwitterCard::setImage($data['image']); // add image url
//        } else {
//            TwitterCard::setImage($this->homePageSeoData['home_page_image_url']); // add image url
//        }

        TwitterCard::setSite($data['site']); // site of twitter card tag
        TwitterCard::setUrl(url()->current()); // url of twitter card tag

        if (isset($data['read_time'])) {
            TwitterCard::addValue('label1', 'Est. reading time'); // value can be string or array
            TwitterCard::addValue('data1', $data['read_time']); // value can be string or array
        }

//        JsonLd::addValue($key, $value); // value can be string or array
        JsonLd::setType($data['type']); // type of twitter card tag
        JsonLd::setTitle($data['title']); // title of twitter card tag
        JsonLd::setDescription($data['description']); // description of twitter card tag
//
//        if ($data['image']) {
//
//         JsonLd::setImage($data['image']); // add image url
//        } else {
//            JsonLd::setImage($this->homePageSeoData['home_page_image_url']); // add image url
//        }
        JsonLd::setSite('@DemoBlog'); // site of twitter card tag
        JsonLd::setUrl(url()->current()); // url of twitter card tag
    }
}
