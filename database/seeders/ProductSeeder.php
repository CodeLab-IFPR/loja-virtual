<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destaqueCategory = Category::where('slug', 'produtos-destaque')->first();
        $premiumCategory = Category::where('slug', 'categoria-premium')->first();
        $especialCategory = Category::where('slug', 'categoria-especial')->first();
        $profissionalCategory = Category::where('slug', 'linha-profissional')->first();
        $compactaCategory = Category::where('slug', 'linha-compacta')->first();

        $products = [
            [
                'name' => 'Produto Premium Modelo A',
                'slug' => 'produto-premium-modelo-a',
                'description' => 'Produto de alta qualidade, modelo A, ideal para uso profissional e comercial.',
                'specifications' => 'Altura: 15cm, Largura: 12cm, Material: Premium',
                'sku' => 'PREM-A-001',
                'price' => 25.90,
                'stock' => 50,
                'active' => true,
                'featured' => true,
                'category_id' => $destaqueCategory->id,
            ],
            [
                'name' => 'Produto Premium Modelo B',
                'slug' => 'produto-premium-modelo-b',
                'description' => 'Produto de alta qualidade, modelo B, versátil para diversos ambientes.',
                'specifications' => 'Altura: 20cm, Largura: 16cm, Material: Premium Plus',
                'sku' => 'PREM-B-002',
                'price' => 39.90,
                'stock' => 30,
                'active' => true,
                'featured' => false,
                'category_id' => $destaqueCategory->id,
            ],
            [
                'name' => 'Produto Especial Design',
                'slug' => 'produto-especial-design',
                'description' => 'Produto com design diferenciado e elegante, perfeito para projetos especiais.',
                'specifications' => 'Altura: 25cm, Largura: 18cm, Material: Design exclusivo',
                'sku' => 'ESP-DES-001',
                'price' => 79.90,
                'stock' => 15,
                'active' => true,
                'featured' => true,
                'category_id' => $especialCategory->id,
            ],
            [
                'name' => 'Produto Profissional Grande',
                'slug' => 'produto-profissional-grande',
                'description' => 'Produto de grande porte para uso profissional e aplicações comerciais.',
                'specifications' => 'Altura: 40cm, Largura: 35cm, Material: Industrial',
                'sku' => 'PROF-GRA-001',
                'price' => 129.90,
                'stock' => 8,
                'active' => true,
                'featured' => false,
                'category_id' => $profissionalCategory->id,
            ],
            [
                'name' => 'Produto Compacto Premium',
                'slug' => 'produto-compacto-premium',
                'description' => 'Produto compacto e premium, ideal para espaços reduzidos.',
                'specifications' => 'Altura: 8cm, Largura: 6cm, Material: Compacto Premium',
                'sku' => 'COMP-PREM-001',
                'price' => 19.90,
                'stock' => 100,
                'active' => true,
                'featured' => false,
                'category_id' => $compactaCategory->id,
            ],
            [
                'name' => 'Produto Premium Deluxe',
                'slug' => 'produto-premium-deluxe',
                'description' => 'Produto premium linha deluxe com acabamento especial.',
                'specifications' => 'Altura: 30cm, Largura: 25cm, Material: Deluxe',
                'sku' => 'PREM-DEL-001',
                'price' => 159.90,
                'stock' => 12,
                'active' => true,
                'featured' => true,
                'category_id' => $premiumCategory->id,
            ],
        ];

        foreach ($products as $productData) {
            Product::firstOrCreate(
                ['sku' => $productData['sku']],
                $productData
            );
        }
    }
}
