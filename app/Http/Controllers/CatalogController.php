<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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

        // Configurable slides for the homepage carousel
        $slides = [
            [
                'image' => asset('images/slides/slide1.svg'),
                'title' => 'Grandes Ofertas em Vasos',
                'subtitle' => 'Confira peças selecionadas com desconto',
                'link' => route('catalog'),
            ],
            [
                'image' => asset('images/slides/slide2.svg'),
                'title' => 'Coleção Primavera',
                'subtitle' => 'Novas texturas e cores para seus vasos',
                'link' => route('catalog'),
            ],
            [
                'title' => 'Entrega Rápida',
                'subtitle' => 'Compre hoje e receba em até 3 dias úteis',
                'link' => route('catalog'),
            ],
        ];

        return view('catalog.index', compact('featuredProducts', 'categories', 'slides'));
    }

    public function catalog(Request $request)
    {
        $query = Product::where('active', true)->with('category');

        // Filtrar por categoria se fornecida
        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Busca por nome
        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);
        $categories = Category::where('active', true)->orderBy('sort_order')->get();

        return view('catalog.catalog', compact('products', 'categories'));
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
