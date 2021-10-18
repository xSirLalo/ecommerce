<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;

class ColorSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = Size::all();

        foreach ($sizes as $size) {
            $size->colors()
                ->attach([
                    1 => ['quantity' => 10],
                    2 => ['quantity' => 9],
                    3 => ['quantity' => 8],
                    4 => ['quantity' => 7],
                ]);
        }
    }
}
