<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Device;
use App\Models\Favorite;
use App\Models\Keyword;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Favorite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'device_id' => Device::factory()->create()->id,
            'article_id' => Article::factory()->create()->id,
        ];
    }
}
