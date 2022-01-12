<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'keywords' => 'adventure',
            'is_video'=>false,
            'is_published'=>false,
            'name' =>  Str::random(15),
            'slug' => Str::random(5),
            'excerpt' => 'travel',
            'position'=>1
        ]);
    }
}
