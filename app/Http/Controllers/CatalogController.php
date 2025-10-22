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

        return view('catalog.index', compact('featuredProducts', 'categories'));
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

        if ($request->price) {
            switch ($request->price) {
                case 'Até R$ 100':
                    $query->where('price', '<=', 100.00);
                    break;
                case 'R$ 100 a R$ 200':
                    $query->whereBetween('price', [100.01, 200.00]);
                    break;
                case 'R$ 200 a R$ 300':
                    $query->whereBetween('price', [200.01, 300.00]);
                    break;
            }
        }

        // Filtrar por cor se fornecida
        if ($request->color) {
            $query->where('color', $request->color);
        }

        // Filtrar por dimensões se fornecida
        if ($request->dimensions) {
            $query->where('dimensions', $request->dimensions);
        }

        $products = $query->paginate(12);
        $categories = Category::where('active', true)->orderBy('sort_order')->get();
        $cores = Product::where('active', true)->pluck('color')->unique();
        $dimensoes = Product::where('active', true)->pluck('dimensions')->unique();

        return view('catalog.catalog', compact('products', 'categories', 'cores', 'dimensoes'));
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
