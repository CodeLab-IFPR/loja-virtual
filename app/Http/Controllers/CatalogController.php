<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

        $slides = [];
        $folderName = 'images/slides';
        $slidePath = public_path($folderName);

        if (File::isDirectory($slidePath)) {

            $files = File::files($slidePath);

            foreach ($files as $file) {
                $filename = $file->getFilename();
                $title = pathinfo($filename, PATHINFO_FILENAME);
                $title = ucfirst(str_replace(['-', '_'], ' ', $title));

                $slides[] = [
                    'image' => asset($folderName . '/' . $filename),
                    'title' => $title,
                    'subtitle' => 'Confira nossas novas coleções',
                    'link' => route('catalog'),
                ];
            }
        }

        if (empty($slides)) {
            $slides[] = [
                'image' => null,
                'title' => 'Bem-vindo ao Nosso Catálogo',
                'subtitle' => 'Explore nossos produtos artesanais.',
                'link' => route('catalog'),
            ];
        }

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
