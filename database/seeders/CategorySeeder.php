<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Vasos Redondos',
                'slug' => 'vasos-redondos',
                'description' => 'Vasos cilíndricos e tipo balde em cimento, do tamanho P ao GG. Ideais para jardins, varandas e decoração de interiores.',
                'active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Vasos Quadrados e Retangulares',
                'slug' => 'vasos-quadrados-retangulares',
                'description' => 'Vasos de formato quadrado e retangular em cimento, com linhas retas e contemporâneas. Perfeitos para projetos de paisagismo moderno.',
                'active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Vasos Cônicos e Trapezoidais',
                'slug' => 'vasos-conicos-trapezoidais',
                'description' => 'Vasos no formato cônico e trapezoidal, clássicos no paisagismo. Disponíveis em diferentes acabamentos e tamanhos.',
                'active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Jardineiras',
                'slug' => 'jardineiras',
                'description' => 'Jardineiras retangulares em cimento para muros, alambrados, varandas e bordas. Ótimas para canteiros lineares e plantas trepadeiras.',
                'active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Cachepots e Decorativos',
                'slug' => 'cachepots-decorativos',
                'description' => 'Cachepots sem furos de drenagem para uso decorativo interno e externo. Inclui formatos hexagonais, ovais e esféricos.',
                'active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
