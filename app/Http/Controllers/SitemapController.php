<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $products = Product::where('status', 'active')->select('slug', 'updated_at')->get();
        $categories = Category::where('status', 'active')->select('slug', 'updated_at')->get();

        $content = view('sitemap', compact('products', 'categories'))->render();

        return response($content, 200)->header('Content-Type', 'application/xml');
    }
}
