<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->word;
        return [
            'name' => $name,
            'slug' => str_slug($name, '-'),
            'excerpt' => $this->faker->sentence(12),
            'keywords' => implode(',', $this->faker->words()),
            'is_video' => $this->faker->boolean(),
            'is_published' => $this->faker->boolean(),
            'position' => 1
        ];
    }
}
