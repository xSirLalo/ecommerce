<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Seeder;
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
        $categories = [
            [
                'name' => 'Celulares y tables',
                'slug' => Str::slug('Celulares y tablets'),
                'icon' => '<i class="fab fa-bitcoin"></i>',
            ],
            [
                'name' => 'TV, audio y video',
                'slug' => Str::slug('TV, audio y video'),
                'icon' => '<i class="fab fa-bitcoin"></i>',
            ],
            [
                'name' => 'Consolas y videojuegos',
                'slug' => Str::slug('Consolas y videojuegos'),
                'icon' => '<i class="fab fa-bitcoin"></i>',
            ],
            [
                'name' => 'Computadoras',
                'slug' => Str::slug('Computadoras'),
                'icon' => '<i class="fab fa-bitcoin"></i>',
            ],
            [
                'name' => 'Moda',
                'slug' => Str::slug('Moda'),
                'icon' => '<i class="fab fa-bitcoin"></i>',
            ],
        ];

        foreach ($categories as $category) {
            $category = Category::factory(1)->create($category)->first();

            $brands = Brand::factory(4)->create();

            foreach ($brands as $brand) {
                $brand->categories()->attach($category->id);
            }
        }
    }
}
