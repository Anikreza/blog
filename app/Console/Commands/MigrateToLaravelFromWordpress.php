<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Category;
use App\Models\Keyword;
use Carbon\Carbon;
use Corcel\Model\Post;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Throwable;

class MigrateToLaravelFromWordpress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clone:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It copies articles from wordpress to laravel';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws Throwable
     */


    public function handle()
    {
        $posts = Post::published()->type('post')->latest()->get()->toArray();

        foreach ($posts as $post) {
            try {
                \DB::beginTransaction();
                $userId = 1;
                $categoryCount = Category::count();
                $category = Category::updateOrCreate(
                    ['name' => $post['main_category']],
                    ['slug' => \Str::slug($post['main_category']), 'excerpt' => $post['main_category'], 'position' => $categoryCount++, 'keywords' => $post['main_category']]
                );

                $viewCollection = collect($post['meta'])->where('meta_key', '=', 'gillion_post_views')->first();
                $viewed = count($viewCollection) ? $viewCollection['value'] : 0;
                $this->info('viewed: ' . $viewed);

                $data = [
                    'user_id' => $userId,
                    'title' => $post['title'],
                    'slug' => $post['slug'],
                    'excerpt' => $post['excerpt'] != '' ? $post['excerpt'] : \Str::limit(strip_tags($post['content']), 320, '...'),
                    'featured' => rand(0, 1),
                    'description' => nl2br($post['content']),
                    'published' => 1,
                    'is_video' => 0,
                    'meta_title' => $post['title'],
                    'read_time' => estimate_reading_time($post['content']),
                    'viewed' => (int)$viewed,
                    'cover_caption' => $post['thumbnail']['attachment']['caption'] ?? null,
                    'created_at' => Carbon::parse($post['created_at']),
                    'updated_at' => Carbon::parse($post['updated_at']),
                ];

                if ($post['image'] !== '') {
                    $image = $post['image'];
                    $filename = time() . '-' . basename($image);

                    $path = public_path('storage/articles/');
                    $thumbPath = public_path('storage/articles/' . 'thumb_');

                    if (!File::exists($path)) {
                        File::makeDirectory($path);
                    }

                    Image::make($image)->resize(null, 675, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($path . $filename);
                    Image::make($image)->resize(null, 200, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($thumbPath . $filename);

                    $data['image'] = $filename;
                }

                $article = Article::create($data);

                // Category
                $article->categories()->sync([$category->id]);

                // Keywords
                $newKeywords = $post['keywords'];
                $keywordIds = [];

                foreach ($newKeywords as $keyword) {
                    $keyword = Keyword::firstOrCreate(['title' => $keyword]);
                    array_push($keywordIds, $keyword->id);
                }

                $article->keywords()->sync($keywordIds);

                \DB::commit();

                $this->info('Article Complete: ' . $article->title);

            } catch (Throwable $throwable) {
                \DB::rollBack();

                \Log::info('Article Could not fetch:' . $post['title']);
                \Log::error('Error:' . $throwable->getMessage() . ' | Line: ' . $throwable->getLine());
                $this->info('Error:' . $throwable->getMessage() . ' | Line: ' . $throwable->getLine());
            }
        }

        return true;
    }
}
