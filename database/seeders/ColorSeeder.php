<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            [
                'name' => 'Cimento Natural',
                'slug' => 'cimento-natural',
                'description' => 'Tom cinza padrão do cimento, sem pigmentação',
                'active' => true,
            ],
            [
                'name' => 'Branco Neve',
                'slug' => 'branco-neve',
                'description' => 'Cimento pigmentado na cor branca, acabamento liso',
                'active' => true,
            ],
            [
                'name' => 'Preto Grafite',
                'slug' => 'preto-grafite',
                'description' => 'Cimento pigmentado em grafite escuro, visual contemporâneo',
                'active' => true,
            ],
            [
                'name' => 'Terracota',
                'slug' => 'terracota',
                'description' => 'Tom avermelhado que remete ao barro natural',
                'active' => true,
            ],
            [
                'name' => 'Verde Musgo',
                'slug' => 'verde-musgo',
                'description' => 'Verde escuro harmônico, ideal para jardins externos',
                'active' => true,
            ],
            [
                'name' => 'Areia',
                'slug' => 'areia',
                'description' => 'Bege amarelado que imita o tom da areia grossa',
                'active' => true,
            ],
        ];

        foreach ($colors as $color) {
            Color::firstOrCreate(
                ['slug' => $color['slug']],
                $color
            );
        }
    }
}
