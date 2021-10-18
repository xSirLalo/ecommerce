<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = ['White', 'Blue', 'Red', 'Black'];

        foreach ($colors as $color) {
            Color::create([
                'name' => $color,
            ]);
        }
    }
}
