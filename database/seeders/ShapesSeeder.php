<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shape;

class ShapesSeeder extends Seeder
{
    public function run(): void
    {
        $shapes = [
            ['name' => 'SUV', 'logo' => '1752771367DxS4yDdQkcLgmKBYLhmP.webp'],
            ['name' => 'Sedan', 'logo' => '17527715087qFOFiyZKH4Qgc5M97gE.jpg'],
            ['name' => 'Hatchback', 'logo' => '1752771469qabwLjSg9F0cP3ukUjtX.png'],
            ['name' => 'Coupe', 'logo' => '1752771579EN4sI6CpISD3lbggLiI8.png'],
            ['name' => 'Wagon', 'logo' => '1752771720WeXciAA6KAxV3wmzOj3j.jpg'],
            ['name' => 'MPV', 'logo' => '1752771795CFshhFsG3UrwxXYSbwSl.png'],
            ['name' => 'CUV', 'logo' => '1752771867ytim1AyKeygGdfdFQ6ax.png'],
        ];

        foreach ($shapes as $shape) {
            Shape::firstOrCreate(['name' => $shape['name']], $shape);
        }
    }
}
