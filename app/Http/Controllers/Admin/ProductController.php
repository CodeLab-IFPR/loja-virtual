<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use App\Models\Material;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::with('category', 'sizes');

        // Busca por nome, descrição ou SKU
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Filtro por categoria
        if ($request->has('category') && $request->category !== '') {
            $query->where('category_id', $request->category);
        }

        // Filtro por status
        if ($request->has('active') && $request->active !== '') {
            $query->where('active', $request->active === '1');
        }

        // Filtro por estoque
        if ($request->has('stock_status') && $request->stock_status !== '') {
            if ($request->stock_status === 'in_stock') {
                $query->where('stock', '>', 0);
            } elseif ($request->stock_status === 'out_of_stock') {
                $query->where('stock', '=', 0);
            } elseif ($request->stock_status === 'low_stock') {
                $query->where('stock', '>', 0)->where('stock', '<=', 10);
            }
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = Category::where('active', true)->orderBy('name')->get();

        $stats = [
            'total' => Product::count(),
            'active' => Product::where('active', true)->count(),
            'inactive' => Product::where('active', false)->count(),
            'in_stock' => Product::where('stock', '>', 0)->count(),
            'out_of_stock' => Product::where('stock', '=', 0)->count(),
        ];

        return view('admin.products.index', compact('products', 'categories', 'stats'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(Request $request)
    {
        $categories = Category::where('active', true)->orderBy('name')->get();
        $sizes = Size::where('active', true)->orderBy('sort_order')->get();
        $materials = Material::where('active', true)->orderBy('name')->get();
        $colors = Color::where('active', true)->orderBy('name')->get();
        $selectedCategory = $request->get('category');

        return view('admin.products.create', compact('categories', 'sizes', 'materials', 'colors', 'selectedCategory'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'nullable|integer|min:0',
            'manage_stock' => 'boolean',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'boolean',
            'featured' => 'boolean',
            'sizes'         => 'nullable|array',
            'sizes.*'       => 'exists:sizes,id',
            'size_prices'   => 'nullable|array',
            'size_prices.*' => 'nullable|numeric|min:0',
            'color_id' => 'nullable|exists:colors,id',
            'material_id' => 'nullable|exists:materials,id',
        ]);

        $data = $request->except(['sizes', 'size_prices']);
        $data['slug'] = Str::slug($request->name);
        $data['active'] = $request->has('active');
        $data['featured'] = $request->has('featured');
        $data['manage_stock'] = $request->has('manage_stock');

        // Compute product price as minimum of size prices
        $sizePrices = $request->input('size_prices', []);
        $validPrices = array_filter(array_values($sizePrices), fn($p) => is_numeric($p) && $p >= 0);
        $data['price'] = !empty($validPrices) ? min($validPrices) : 0;

        // Upload da imagem principal
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Upload das imagens adicionais
        if ($request->hasFile('images')) {
            $additionalImages = [];
            foreach ($request->file('images') as $index => $image) {
                $imageName = time() . '_' . $index . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('products', $imageName, 'public');
                $additionalImages[] = $imagePath;
            }
            $data['images'] = $additionalImages;
        } else {
            $data['images'] = [];
        }

        $product = Product::create($data);

        // Sync sizes with per-size prices
        $sizePrices = $request->input('size_prices', []);
        $syncData = [];
        foreach ($request->input('sizes', []) as $sizeId) {
            $syncData[$sizeId] = ['price' => $sizePrices[$sizeId] ?? 0];
        }
        $product->sizes()->sync($syncData);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produto criado com sucesso!');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load('sizes', 'color', 'material');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('active', true)->orderBy('name')->get();
        $sizes = Size::where('active', true)->orderBy('sort_order')->get();
        $materials = Material::where('active', true)->orderBy('name')->get();
        $colors = Color::where('active', true)->orderBy('name')->get();

        $product->load('sizes');
        $selectedSizes = $product->sizes->pluck('id')->toArray();
        $selectedSizePrices = $product->sizes->pluck('pivot.price', 'id')->toArray();

        return view('admin.products.edit', compact('product', 'categories', 'sizes', 'materials', 'colors', 'selectedSizes', 'selectedSizePrices'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'nullable|integer|min:0',
            'manage_stock' => 'boolean',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'boolean',
            'featured' => 'boolean',
            'sizes'         => 'nullable|array',
            'sizes.*'       => 'exists:sizes,id',
            'size_prices'   => 'nullable|array',
            'size_prices.*' => 'nullable|numeric|min:0',
            'color_id' => 'nullable|exists:colors,id',
            'material_id' => 'nullable|exists:materials,id',
        ]);

        $data = $request->except(['sizes', 'size_prices']);
        $data['slug'] = Str::slug($request->name);
        $data['active'] = $request->has('active');
        $data['featured'] = $request->has('featured');
        $data['manage_stock'] = $request->has('manage_stock');

        // Compute product price as minimum of size prices
        $sizePrices = $request->input('size_prices', []);
        $validPrices = array_filter(array_values($sizePrices), fn($p) => is_numeric($p) && $p >= 0);
        $data['price'] = !empty($validPrices) ? min($validPrices) : 0;

        // Upload da imagem principal
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        // Upload das novas imagens adicionais
        $existingImages = $product->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imageName = time() . '_' . $index . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('products', $imageName, 'public');
                $existingImages[] = $imagePath;
            }
        }

        // Remover imagens selecionadas
        $removeImages = $request->input('remove_additional_images', []);
        foreach ($removeImages as $removeImage) {
            if (Storage::disk('public')->exists($removeImage)) {
                Storage::disk('public')->delete($removeImage);
            }
            $existingImages = array_filter($existingImages, fn($img) => $img !== $removeImage);
        }

        $data['images'] = array_values($existingImages);

        $product->update($data);

        // Sync sizes with per-size prices
        $sizePrices = $request->input('size_prices', []);
        $syncData = [];
        foreach ($request->input('sizes', []) as $sizeId) {
            $syncData[$sizeId] = ['price' => $sizePrices[$sizeId] ?? 0];
        }
        $product->sizes()->sync($syncData);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        if ($product->images && is_array($product->images)) {
            foreach ($product->images as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produto excluído com sucesso!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroyImage(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        
        $data['image'] = null;

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Imagem principal excluída com sucesso!');
    }

    /**
     * Toggle product status (active/inactive).
     */
    public function toggleStatus(Product $product)
    {
        $product->update(['active' => !$product->active]);

        $status = $product->active ? 'ativado' : 'desativado';
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Produto {$status} com sucesso!",
                'active' => $product->active
            ]);
        }

        return redirect()->back()->with('success', "Produto {$status} com sucesso!");
    }

    /**
     * Update stock quantity.
     */
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
            'action' => 'required|in:set,add,subtract'
        ]);

        $newStock = $product->stock;

        switch ($request->action) {
            case 'set':
                $newStock = $request->stock;
                break;
            case 'add':
                $newStock += $request->stock;
                break;
            case 'subtract':
                $newStock = max(0, $newStock - $request->stock);
                break;
        }

        $product->update(['stock' => $newStock]);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Estoque atualizado com sucesso!',
                'stock' => $newStock
            ]);
        }

        return redirect()->back()->with('success', 'Estoque atualizado com sucesso!');
    }

    public function exportCatalogPdf(Request $request)
    {
        $query = Product::with('category');
 
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }
 
        if ($request->has('category') && $request->category !== '') {
            $query->where('category_id', $request->category);
        }
 
        if ($request->has('active') && $request->active !== '') {
            $query->where('active', $request->active === '1');
        }
 
        if ($request->has('stock_status') && $request->stock_status !== '') {
            if ($request->stock_status === 'in_stock') {
                $query->where('stock', '>', 0);
            } elseif ($request->stock_status === 'out_of_stock') {
                $query->where('stock', '=', 0);
            } elseif ($request->stock_status === 'low_stock') {
                $query->where('stock', '>', 0)->where('stock', '<=', 10);
            }
        }
 
        $products = $query->orderBy('name')->get();
 
        // Converte a foto principal de cada produto para base64,
        // já que o DomPDF não renderiza bem imagens via URL/HTTP.
        $products->each(function (Product $product) {
            $product->pdf_image = $this->getMainImageAsBase64($product);
        });
 
        $pdf = Pdf::loadView('admin.products.pdf.catalog', [
            'products' => $products,
            'generatedAt' => now(),
            'filters' => $request->only(['search', 'category', 'active', 'stock_status']),
        ])->setPaper('a4', 'portrait');
 
        return $pdf->download('catalogo-produtos-' . now()->format('Y-m-d_H-i') . '.pdf');
    }
 
    /**
     * Retorna a imagem principal do produto como data URI base64,
     * ou null caso não exista/seja inválida (o PDF usa um placeholder nesse caso).
     */
    private function getMainImageAsBase64(Product $product): ?string
    {
        if (!$product->image || !Storage::disk('public')->exists($product->image)) {
            return null;
        }
 
        $absolutePath = Storage::disk('public')->path($product->image);
 
        if (!is_file($absolutePath)) {
            return null;
        }
 
        $mimeType = mime_content_type($absolutePath);
        if (!$mimeType || !str_starts_with($mimeType, 'image/')) {
            return null;
        }
 
        $contents = @file_get_contents($absolutePath);
        if ($contents === false) {
            return null;
        }
 
        return 'data:' . $mimeType . ';base64,' . base64_encode($contents);
    }
}