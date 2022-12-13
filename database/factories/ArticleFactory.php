<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $images = [
            'demo-image-1.jpg',
            'demo-image-2.jpg',
            'demo-image-3.jpg',
            'demo-image-4.jpg',
            'demo-image-5.jpg',
            'demo-image-6.jpg',
        ];
        $title = $this->faker->sentence;
        return [
            'user_id' => function () {
                return User::factory()->create();
            },
            'title' => $title,
            'slug' => str_slug($title, '-'),
            'description' => $this->faker->text,
            'excerpt' => $this->faker->sentence(12),
            'image' => $this->faker->randomElement($images),
            'image_disk' => 'public',
            'meta_title' => $title,
            'published' => $this->faker->boolean(),
            'featured' => $this->faker->boolean(),
            'viewed' => $this->faker->numberBetween(0, 1000),
            'read_time' => $this->faker->numberBetween(1, 30)
        ];
    }
}
