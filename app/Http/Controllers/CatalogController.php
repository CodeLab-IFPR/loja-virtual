<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Color;
use App\Models\Material;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CatalogController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('active', true)
            ->where('featured', true)
            ->with('category')
            ->limit(6)
            ->get();

        $categories = Category::where('active', true)
            ->orderBy('sort_order')
            ->get();

        // Carregar slides dinâmicos
        $slides = [];
        $folderName = 'images/slides';
        $slidePath = public_path($folderName);

        if (File::isDirectory($slidePath)) {
            $files = File::files($slidePath);
            $slideIndex = 0;

            foreach ($files as $file) {
                $filename = $file->getFilename();
                $title = pathinfo($filename, PATHINFO_FILENAME);
                $title = ucfirst(str_replace(['-', '_'], ' ', $title));

                // Alterna a posição do texto entre esquerda e direita
                $textPosition = ($slideIndex % 2 != 0) ? 'left' : 'right';

                $slides[] = [
                    'image' => asset($folderName . '/' . $filename),
                    'title' => $title,
                    'subtitle' => 'Confira nossas novas coleções',
                    'description' => 'Produtos artesanais de alta qualidade, feitos com dedicação e amor ao artesanato.',
                    'button_text' => 'Ver Catálogo',
                    'link' => route('catalog'),
                    'secondary_button_text' => 'Saiba Mais',
                    'secondary_link' => route('catalog'),
                    'text_position' => $textPosition, // 'left', 'right' ou 'center'
                ];
                
                $slideIndex++;
            }
        }

        // Fallback se não houver slides - exemplo com diferentes posições
        if (empty($slides)) {
            $slides = [
                [
                    'image' => null,
                    'title' => 'DIVERSOS MODELOS',
                    'subtitle' => 'QUALIDADE E TRADIÇÃO',
                    'description' => 'Descubra nossa coleção exclusiva de vasos artesanais, feitos com dedicação e técnicas tradicionais.',
                    'button_text' => 'Ver Catálogo',
                    'link' => route('catalog'),
                    'secondary_button_text' => 'Saiba Mais',
                    'secondary_link' => route('catalog'),
                    'text_position' => 'left', // Texto à esquerda
                ],
                [
                    'image' => null,
                    'title' => 'ARTESANATO EXCLUSIVO',
                    'subtitle' => 'FEITO À MÃO',
                    'description' => 'Cada peça é única e carrega a tradição do artesanato brasileiro.',
                    'button_text' => 'Ver Catálogo',
                    'link' => route('catalog'),
                    'secondary_button_text' => 'Contato',
                    'secondary_link' => route('catalog'),
                    'text_position' => 'right', // Texto à direita
                ],
            ];
        }

        // Adiciona cores e materiais
        $colors = Color::where('active', true)->get();
        $materials = Material::where('active', true)->get();

        return view('catalog.index', compact(
            'featuredProducts',
            'categories',
            'slides',
            'colors',
            'materials'
        ));
    }

    public function catalog(Request $request)
    {
        $query = Product::where('active', true)->with('category');

        if ($request->has('categories') && !empty($request->categories)) {
            $query->whereIn('category_id', $request->categories);
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('price_ranges') && !empty($request->price_ranges)) {
            $query->where(function ($q) use ($request) {
                foreach ($request->price_ranges as $range) {
                    switch ($range) {
                        case '0-100':
                            $q->orWhere('price', '<=', 100.00);
                            break;
                        case '100-200':
                            $q->orWhereBetween('price', [100.01, 200.00]);
                            break;
                        case '200-300':
                            $q->orWhereBetween('price', [200.01, 300.00]);
                            break;
                    }
                }
            });
        }

        if ($request->has('colors') && !empty($request->colors)) {
            $query->whereIn('color_id', $request->colors);
        }

        if ($request->has('materials') && !empty($request->materials)) {
            $query->whereIn('material_id', $request->materials);
        }

        if ($request->has('dimensions') && !empty($request->dimensions)) {
            $query->whereIn('dimensions', $request->dimensions);
        }

        $products = $query->paginate(12);
        $categories = Category::where('active', true)->orderBy('sort_order')->get();
        $colors = Color::where('active', true)->get();
        $materials = Material::where('active', true)->get();
        $dimensoes = Product::where('active', true)->pluck('dimensions')->unique();

        return view('catalog.catalog', compact('products', 'categories', 'colors', 'materials', 'dimensoes'));
    }

    public function category(Category $category)
    {
        $products = Product::where('category_id', $category->id)
            ->where('active', true)
            ->paginate(12);

        return view('catalog.category', compact('category', 'products'));
    }

    public function show(Product $product)
    {
        if (!$product->active) {
            abort(404);
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('active', true)
            ->limit(4)
            ->get();

        return view('catalog.show', compact('product', 'relatedProducts'));
    }
}