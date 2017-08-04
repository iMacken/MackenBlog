<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::query()->firstOrNew([
            'slug' => 'category-1',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name'       => '分类一'
            ])->save();
        }

        $category = Category::query()->firstOrNew([
            'slug' => 'category-2',
        ]);
        if (!$category->exists) {
            $category->fill([
                'name'       => '分类二'
            ])->save();
        }
    }
}
