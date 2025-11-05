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
                'name' => 'Plástico',
                'slug' => 'plastico',
                'description' => 'Biodegradável',
                'active' => true,
            ],
            [
                'name' => 'Cerâmica',
                'slug' => 'ceramica',
                'active' => true,
            ],
            [
                'name' => 'Ferro',
                'slug' => 'ferro',
                'description' => 'Bem pesado',
                'active' => true,
            ],
            [
                'name' => 'Ouro',
                'slug' => 'ouro',
                'description' => 'Bem caro',
                'active' => true,
            ],
            [
                'name' => 'Diamante',
                'slug' => 'diamante',
                'active' => true,
            ],
            [
                'name' => 'Obsidiana',
                'slug' => 'obsidiana',
                'description' => 'Mistura de lava e água',
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
