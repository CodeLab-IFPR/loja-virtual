<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $redondos    = Category::where('slug', 'vasos-redondos')->first();
        $quadrados   = Category::where('slug', 'vasos-quadrados-retangulares')->first();
        $conicos     = Category::where('slug', 'vasos-conicos-trapezoidais')->first();
        $jardineiras = Category::where('slug', 'jardineiras')->first();
        $cachepots   = Category::where('slug', 'cachepots-decorativos')->first();

        $products = [

            // -------------------------------------------------------
            // VASOS REDONDOS
            // -------------------------------------------------------
            [
                'name'           => 'Vaso Cilíndrico P',
                'slug'           => 'vaso-cilindrico-p',
                'description'    => 'Vaso redondo cilíndrico em cimento polido, tamanho pequeno. Ideal para suculentas, cactos e temperos na cozinha. Possui furo de drenagem e acabamento liso internamente.',
                'specifications' => 'Diâmetro: 15 cm | Altura: 14 cm | Peso: ~1,8 kg | Furo de drenagem: sim | Acabamento: cimento polido liso',
                'sku'            => 'VR-CIL-P',
                'price'          => 28.90,
                'stock'          => 80,
                'manage_stock'   => true,
                'active'         => true,
                'featured'       => true,
                'category_id'    => $redondos->id,
            ],
            [
                'name'           => 'Vaso Cilíndrico M',
                'slug'           => 'vaso-cilindrico-m',
                'description'    => 'Vaso redondo cilíndrico em cimento polido, tamanho médio. Versátil para gramíneas ornamentais, bromélias e plantas de médio porte. Excelente para varandas e jardins externos.',
                'specifications' => 'Diâmetro: 25 cm | Altura: 23 cm | Peso: ~4,5 kg | Furo de drenagem: sim | Acabamento: cimento polido liso',
                'sku'            => 'VR-CIL-M',
                'price'          => 59.90,
                'stock'          => 50,
                'manage_stock'   => true,
                'active'         => true,
                'featured'       => true,
                'category_id'    => $redondos->id,
            ],
            [
                'name'           => 'Vaso Balde G',
                'slug'           => 'vaso-balde-g',
                'description'    => 'Vaso no formato balde (cônico invertido) em concreto estrutural, tamanho grande. Muito utilizado em projetos de paisagismo com árvores de pequeno porte e palmeiras anãs.',
                'specifications' => 'Diâmetro superior: 35 cm | Diâmetro inferior: 27 cm | Altura: 30 cm | Peso: ~9 kg | Furo de drenagem: sim | Acabamento: cimento rústico',
                'sku'            => 'VR-BAL-G',
                'price'          => 119.90,
                'stock'          => 25,
                'manage_stock'   => true,
                'active'         => true,
                'featured'       => false,
                'category_id'    => $redondos->id,
            ],
            [
                'name'           => 'Vaso Balde GG',
                'slug'           => 'vaso-balde-gg',
                'description'    => 'Vaso balde extra grande em concreto estrutural com armação interna. Indicado para árvores de médio porte, bambus e plantas de grande volume. Peça de alto impacto visual em áreas externas.',
                'specifications' => 'Diâmetro superior: 50 cm | Diâmetro inferior: 38 cm | Altura: 45 cm | Peso: ~18 kg | Furo de drenagem: sim | Acabamento: concreto estrutural liso',
                'sku'            => 'VR-BAL-GG',
                'price'          => 249.90,
                'stock'          => 10,
                'manage_stock'   => true,
                'active'         => true,
                'featured'       => true,
                'category_id'    => $redondos->id,
            ],
            [
                'name'           => 'Vaso Redondo Textura Pedra M',
                'slug'           => 'vaso-redondo-textura-pedra-m',
                'description'    => 'Vaso cilíndrico médio com acabamento rústico que imita textura de pedra natural. Produzido com cimento rústico, ideal para composições de jardim com apelo orgânico e natural.',
                'specifications' => 'Diâmetro: 25 cm | Altura: 22 cm | Peso: ~5 kg | Furo de drenagem: sim | Acabamento: cimento rústico textura pedra',
                'sku'            => 'VR-RUS-M',
                'price'          => 74.90,
                'stock'          => 30,
                'manage_stock'   => true,
                'active'         => true,
                'featured'       => false,
                'category_id'    => $redondos->id,
            ],

            // -------------------------------------------------------
            // VASOS QUADRADOS E RETANGULARES
            // -------------------------------------------------------
            [
                'name'           => 'Vaso Quadrado P',
                'slug'           => 'vaso-quadrado-p',
                'description'    => 'Vaso quadrado em cimento polido, tamanho pequeno. Design minimalista e contemporâneo, perfeito para composições de vasos em grupos. Ótimo para uso interno sobre bancadas e mesas.',
                'specifications' => 'Largura: 20 cm | Comprimento: 20 cm | Altura: 18 cm | Peso: ~3 kg | Furo de drenagem: sim | Acabamento: cimento polido',
                'sku'            => 'VQ-020',
                'price'          => 45.90,
                'stock'          => 40,
                'manage_stock'   => true,
                'active'         => true,
                'featured'       => false,
                'category_id'    => $quadrados->id,
            ],
            [
                'name'           => 'Vaso Quadrado M',
                'slug'           => 'vaso-quadrado-m',
                'description'    => 'Vaso quadrado em cimento polido, tamanho médio. Muito solicitado por arquitetos e paisagistas para projetos modernos com linhas retas. Compatível com plantas de médio porte como ficus e dracenas.',
                'specifications' => 'Largura: 30 cm | Comprimento: 30 cm | Altura: 28 cm | Peso: ~7 kg | Furo de drenagem: sim | Acabamento: cimento polido',
                'sku'            => 'VQ-030',
                'price'          => 89.90,
                'stock'          => 20,
                'manage_stock'   => true,
                'active'         => true,
                'featured'       => true,
                'category_id'    => $quadrados->id,
            ],
            [
                'name'           => 'Vaso Retangular M',
                'slug'           => 'vaso-retangular-m',
                'description'    => 'Vaso retangular em cimento polido, formato alongado. Indicado para composições com múltiplas plantas em um único vaso, como suculentas variadas ou ervas aromáticas.',
                'specifications' => 'Comprimento: 40 cm | Largura: 20 cm | Altura: 20 cm | Peso: ~6 kg | Furo de drenagem: sim | Acabamento: cimento polido',
                'sku'            => 'VRT-040',
                'price'          => 99.90,
                'stock'          => 15,
                'manage_stock'   => true,
                'active'         => true,
                'featured'       => false,
                'category_id'    => $quadrados->id,
            ],

            // -------------------------------------------------------
            // VASOS CÔNICOS E TRAPEZOIDAIS
            // -------------------------------------------------------
            [
                'name'           => 'Vaso Cônico Clássico M',
                'slug'           => 'vaso-conico-classico-m',
                'description'    => 'Vaso cônico no estilo clássico do paisagismo, maior na boca e menor na base. Em cimento rústico com aspecto natural, muito utilizado em entradas de residências e condomínios.',
                'specifications' => 'Diâmetro superior: 30 cm | Diâmetro inferior: 15 cm | Altura: 25 cm | Peso: ~5,5 kg | Furo de drenagem: sim | Acabamento: cimento rústico',
                'sku'            => 'VC-CLA-M',
                'price'          => 79.90,
                'stock'          => 25,
                'manage_stock'   => true,
                'active'         => true,
                'featured'       => false,
                'category_id'    => $conicos->id,
            ],
            [
                'name'           => 'Vaso Trapezoidal G',
                'slug'           => 'vaso-trapezoidal-g',
                'description'    => 'Vaso trapezoidal de grande porte, com boca larga e base menor, em concreto estrutural pigmentado. Peça de destaque para projetos de paisagismo em áreas abertas, praças e condomínios.',
                'specifications' => 'Diâmetro superior: 45 cm | Diâmetro inferior: 30 cm | Altura: 35 cm | Peso: ~14 kg | Furo de drenagem: sim | Acabamento: concreto pigmentado',
                'sku'            => 'VC-TRP-G',
                'price'          => 169.90,
                'stock'          => 12,
                'manage_stock'   => true,
                'active'         => true,
                'featured'       => true,
                'category_id'    => $conicos->id,
            ],

            // -------------------------------------------------------
            // JARDINEIRAS
            // -------------------------------------------------------
            [
                'name'           => 'Jardineira Slim 60 cm',
                'slug'           => 'jardineira-slim-60cm',
                'description'    => 'Jardineira retangular compacta em cimento polido, ideal para muros, janelas e varandas estreitas. Perfeita para ervas aromáticas, pequenas flores e plantas baixas.',
                'specifications' => 'Comprimento: 60 cm | Largura: 18 cm | Altura: 18 cm | Peso: ~8 kg | Furos de drenagem: 3 | Acabamento: cimento polido',
                'sku'            => 'JD-SLM-060',
                'price'          => 129.90,
                'stock'          => 20,
                'manage_stock'   => true,
                'active'         => true,
                'featured'       => false,
                'category_id'    => $jardineiras->id,
            ],
            [
                'name'           => 'Jardineira Standard 1 m',
                'slug'           => 'jardineira-standard-1m',
                'description'    => 'Jardineira de 1 metro em concreto estrutural, tamanho padrão para muros e canteiros lineares. Alta capacidade para plantas de médio porte, begônias, íris e folhagens.',
                'specifications' => 'Comprimento: 100 cm | Largura: 25 cm | Altura: 25 cm | Peso: ~18 kg | Furos de drenagem: 5 | Acabamento: concreto estrutural liso',
                'sku'            => 'JD-STD-100',
                'price'          => 219.90,
                'stock'          => 12,
                'manage_stock'   => true,
                'active'         => true,
                'featured'       => true,
                'category_id'    => $jardineiras->id,
            ],
            [
                'name'           => 'Jardineira para Alambrado 80 cm',
                'slug'           => 'jardineira-alambrado-80cm',
                'description'    => 'Jardineira com encaixe desenvolvido para fixação em alambrados e grades. Possui suporte metálico integrado para prender na malha sem perfurar o gradil. Ótima para divisas e cercamentos.',
                'specifications' => 'Comprimento: 80 cm | Largura: 20 cm | Altura: 20 cm | Peso: ~12 kg | Furos de drenagem: 4 | Suporte: aço galvanizado incluso | Acabamento: fibrocimento',
                'sku'            => 'JD-ALA-080',
                'price'          => 159.90,
                'stock'          => 15,
                'manage_stock'   => true,
                'active'         => true,
                'featured'       => false,
                'category_id'    => $jardineiras->id,
            ],

            // -------------------------------------------------------
            // CACHEPOTS E DECORATIVOS
            // -------------------------------------------------------
            [
                'name'           => 'Cachepot Redondo P',
                'slug'           => 'cachepot-redondo-p',
                'description'    => 'Cachepot redondo sem furo de drenagem, em cimento polido. Utilizado para cobrir vasos plásticos, criando visual mais elegante. Ideal para sala de estar, escritórios e recepções.',
                'specifications' => 'Diâmetro: 15 cm | Altura: 13 cm | Peso: ~1,5 kg | Furo de drenagem: não | Acabamento: cimento polido',
                'sku'            => 'CP-RED-P',
                'price'          => 25.90,
                'stock'          => 60,
                'manage_stock'   => true,
                'active'         => true,
                'featured'       => false,
                'category_id'    => $cachepots->id,
            ],
            [
                'name'           => 'Cachepot Hexagonal M',
                'slug'           => 'cachepot-hexagonal-m',
                'description'    => 'Cachepot de formato hexagonal sem furo de drenagem, em cimento polido. Design geométrico moderno muito procurado para decoração contemporânea. Pode ser combinado em grupos de diferentes tamanhos.',
                'specifications' => 'Diâmetro externo: 22 cm (vértice a vértice) | Altura: 20 cm | Peso: ~3,2 kg | Furo de drenagem: não | Lados: 6 | Acabamento: cimento polido pigmentado',
                'sku'            => 'CP-HEX-M',
                'price'          => 59.90,
                'stock'          => 25,
                'manage_stock'   => true,
                'active'         => true,
                'featured'       => true,
                'category_id'    => $cachepots->id,
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
