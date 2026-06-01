<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            [
                'name' => 'Cimento Polido',
                'slug' => 'cimento-polido',
                'description' => 'Acabamento liso e polido, visual moderno e limpo',
                'active' => true,
            ],
            [
                'name' => 'Cimento Rústico',
                'slug' => 'cimento-rustico',
                'description' => 'Textura irregular que simula pedra e imita o aspecto bruto do cimento',
                'active' => true,
            ],
            [
                'name' => 'Cimento Marmorizado',
                'slug' => 'cimento-marmorizado',
                'description' => 'Efeito mármore obtido por pigmentação e técnica de mescla',
                'active' => true,
            ],
            [
                'name' => 'Cimento Pigmentado',
                'slug' => 'cimento-pigmentado',
                'description' => 'Cimento tingido em massa com pigmentos minerais permanentes',
                'active' => true,
            ],
            [
                'name' => 'Concreto Estrutural',
                'slug' => 'concreto-estrutural',
                'description' => 'Concreto de alta resistência com aço interno, ideal para peças grandes',
                'active' => true,
            ],
            [
                'name' => 'Fibrocimento',
                'slug' => 'fibrocimento',
                'description' => 'Cimento reforçado com fibra sintética, mais leve e resistente a rupturas',
                'active' => true,
            ],
        ];

        foreach ($materials as $material) {
            Material::firstOrCreate(
                ['slug' => $material['slug']],
                $material
            );
        }
    }
}
