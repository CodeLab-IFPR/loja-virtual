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
                'name' => 'Produtos em Destaque',
                'slug' => 'produtos-destaque',
                'description' => 'Principais produtos da nossa loja com melhor qualidade e preço.',
                'active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Categoria Premium',
                'slug' => 'categoria-premium',
                'description' => 'Produtos premium com design diferenciado e alta qualidade.',
                'active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Categoria Especial',
                'slug' => 'categoria-especial',
                'description' => 'Produtos especiais para necessidades específicas.',
                'active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Linha Profissional',
                'slug' => 'linha-profissional',
                'description' => 'Produtos voltados para uso profissional e comercial.',
                'active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Linha Compacta',
                'slug' => 'linha-compacta',
                'description' => 'Produtos compactos ideais para espaços reduzidos.',
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
