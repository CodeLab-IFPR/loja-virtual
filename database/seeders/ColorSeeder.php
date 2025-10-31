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
                'name' => 'Ciano',
                'slug' => 'ciano',
                'description' => 'Mistura de verde e azul',
                'active' => true,
            ],
            [
                'name' => 'Branco',
                'slug' => 'branco',
                'active' => true,
            ],
            [
                'name' => 'Dourado',
                'slug' => 'dourado',
                'description' => 'Remete a ouro',
                'active' => true,
            ],
            [
                'name' => 'Preto',
                'slug' => 'preto',
                'description' => 'Cor preta absoluta',
                'active' => true,
            ],
            [
                'name' => 'Azul Marinho',
                'slug' => 'azul-marinho',
                'active' => true,
            ],
            [
                'name' => 'Púrpura',
                'slug' => 'purpura',
                'description' => 'Mistura de vermelho e azul',
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
