<?php /** @noinspection ALL */

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Keyword;
use Exception;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Article::factory()->count(50)->create();
        \DB::beginTransaction();
        try {

            $categories = Category::pluck('id')->toArray();
            $keywords = Keyword::pluck('id')->toArray();

            foreach ($categories as $category) {
                for ($i = 0; $i < 5; $i++) {
                    $article = Article::factory()->create();
                    $article->categories()->sync($category);
                    $article->keywords()->sync(collect($keywords)->shuffle()->slice(0, 3));
                }
            }
            \DB::commit();
        } catch (Exception $exception) {
            \DB::rollBack();
        }
    }
}
