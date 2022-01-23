<?php

namespace App\Repositories\Article;

use App\Models\Article;
use App\Models\Keyword;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Str;

class ArticleRepository implements ArticleInterface
{

    private $model;
    private $disk = 'public';

    public function __construct(Article $article)
    {
        $this->model = $article;
    }

    public function save(Request $request)
    {


        $image = $request->image;
        if ($image) {
            $image_ext = $image->getClientOriginalExtension();
            $image_full_name = time() . '.' . $image_ext;
            $upload_path = 'assets/images/';
            $image_url = $upload_path . $image_full_name;

            $image->move($upload_path, $image_full_name);
        } else {
            $image_url = '';
        }

        $article = Article::create([
            'user_id' => auth()->user()->id,
            'title' => $request->input('title'),
            'slug' => $this->slugify($request->input('title')),
            'excerpt' => $request->input('excerpt'),
            'featured' => filter_var($request->input('featured'), FILTER_VALIDATE_BOOLEAN),
            'description' => $request->input('description'),
            'published' => filter_var($request->input('published'), FILTER_VALIDATE_BOOLEAN),
            'image_disk' => $this->disk,
            'meta_title' => $request->input('meta_title'),
            'image' => $image_url,
        ]);
        // Category
        $article->categories()->sync([$request->input('categories')]);

        // Keywords
        $newKeywords = explode(',', $request->input('keywords'));
        $keywordIds = [];

        foreach ($newKeywords as $keyword) {
            $keyword = Keyword::firstOrCreate(['title' => $keyword]);
            array_push($keywordIds, $keyword->id);
        }

        $article->keywords()->sync($keywordIds);
        return $article;
    }

    private function slugify($name): string
    {
        return \Str::slug($name);
    }

    public function update(Request $request, int $id): array
    {
        $article = Article::findOrFail($id);
        $isPublishedBefore = $article->published;

        $image = $request->image;
        if ($image) {
            $image_ext = $image->getClientOriginalExtension();
            $image_full_name = time() . '.' . $image_ext;
            $upload_path = 'assets/images/';
            $image_url = $upload_path . $image_full_name;

            $image->move($upload_path, $image_full_name);
        } else {
            $image_url = '';
        }

        $data = [
            'title' => $request->input('title'),
            'slug' => $this->slugify($request->input('title')),
            'excerpt' => $request->input('excerpt'),
            'featured' => filter_var($request->input('featured'), FILTER_VALIDATE_BOOLEAN),
            'description' => $request->input('description'),
            'published' => filter_var($request->input('published'), FILTER_VALIDATE_BOOLEAN),
            'meta_title' => $request->input('meta_title'),
            'image' => $image_url,
        ];


        // Category
        $article->categories()->detach();
        $article->categories()->sync([$request->input('categories')]);

        // Keywords
        $newKeywords = explode(',', $request->input('keywords'));git branch
        $keywordIds = [];

        foreach ($newKeywords as $keyword) {
            $keyword = Keyword::firstOrCreate(['title' => $keyword]);
            array_push($keywordIds, $keyword->id);
        }

        $article->keywords()->detach();
        $article->keywords()->sync($keywordIds);
        $article->update($data);

        return ['article' => $article, 'previouslyPublished' => $isPublishedBefore];
    }

    public function delete(int $id)
    {
        $article = Article::findOrFail($id);
        File::delete($article->image);
        $article->categories()->detach();
        $article->keywords()->detach();

        return $article->delete();
    }

    public function all(array $columns = [])
    {
        return count($columns) ? Article::select($columns)->orderBy('id')->get() : Article::orderBy('viewed')->get();
    }

    public function paginate($perPage = 10)
    {
        return Article::latest()
            ->with(['categories'])
            ->when(request()->has('category'), function ($q) {
                $q->whereHas('categories', function ($sq) {
                    $sq->where('category_id', \request('category'));
                });
            })
            ->when(request()->has('is_published'), function ($q) {
                $q->where('published', (bool)request('is_published'));
            })
            ->when(\request()->has('search'), function ($q) {
                $q->where('title', 'LIKE', '%' . \request('search') . '%');
            })
            ->orderBy('viewed', 'desc')
            ->paginate($perPage);
    }

    public function paginateWithFilter(int $limit)
    {
        // TODO: Implement paginateWithFilter() method.
    }

    public function paginateByCategoryWithFilter(int $perPage)
    {
        return $this->model
            ->select('id', 'title', 'slug', 'featured', 'published', 'image', 'viewed', 'description')
            ->latest()
            ->paginate($perPage);
    }

    public function getArticleCount()
    {
        return Article::where('created_at', '>', Carbon::now()->subDays(1))
            ->groupBy(\DB::raw('HOUR(created_at)'))
            ->count();
    }

    public function getAllArticleCount(): int
    {
        return Article::all()->count();
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

    public function publishedArticles(int $limit)
    {
        return $this->model
            ->select('id', 'title', 'slug', 'featured', 'published', 'image', 'viewed', 'description')
            ->with('categories')
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function publishedFeaturedArticles( int $limit)
    {
        return $this->model
            ->select('id', 'title', 'slug', 'featured', 'published', 'image', 'viewed', 'description')
            ->where('featured', 1)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function mostReadArticles( int $limit)
    {
        return $this->model
            ->select('id', 'title', 'slug', 'featured', 'published', 'image', 'viewed', 'description')
            ->limit($limit)
            ->orderBy('viewed', 'desc')
            ->get();
    }

    public function getArticle($slug)
    {
        return $this->model->with(['categories' => function ($q) use ($slug) {
            $q->with(['articles' => function ($sq) use ($slug) {
                $sq->select('article_id', 'title', 'slug', 'published', 'viewed', 'image', 'featured', 'description')
                    ->where('published', '=', true);
            }]);
        }])
            ->where('slug', $slug)
            ->first();
    }

    public function getSimilarArticles( $limit)
    {
        return $this->model
            ->select('id', 'title', 'slug', 'published', 'viewed', 'image', 'featured', 'description')
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    public function searchArticles($query, $perPage)
    {
        return $this->model
            ->select('id', 'title', 'slug', 'published', 'viewed', 'image', 'featured', 'description')
            ->where('title', 'LIKE', '%' . $query . '%')
            ->latest()
            ->limit(5)
            ->paginate($perPage);
    }

    public function getAllTags()
    {
        return Keyword::limit(15)->inRandomOrder()->get();
    }

    public function getTagInfoWithArticles($tag, $perPage): array
    {
        $string = Str::title(str_replace('-', ' ', trim($tag)));
        $tag = Keyword::where('title', 'LIKE', '%' . $string . '%')->first();
        $tags = Keyword::all();

        return [
            'tagInfo' => $tag,
            'tags' =>  $tags,
            'articles' =>$this->getArticlesByTag($perPage, $tag->pluck('id')->toArray())
        ];
    }

    public function getArticlesByTag($perPage, array $keywordIds, $includeFavorites = false)
    {
        $q = $this->model->whereHas('keywords', function ($q) use ($keywordIds) {
            $q->whereIn('keyword_id', $keywordIds);
        })
            ->with('categories:id,name,slug')
            ->with('keywords:id,title')
            ->where('published', true)
            ->when($includeFavorites, function ($q) {
                $q->with(['favorites']);
            })
            ->select('id', 'title', 'slug', 'featured', 'published', 'image', 'viewed', 'description')
            ->latest();

        return $perPage === 4 ? $q->limit($perPage)->get() : $q->paginate($perPage);
    }

}
