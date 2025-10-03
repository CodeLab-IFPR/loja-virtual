<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

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
        $selectedCategory = $request->get('category');

        return view('admin.products.create', compact('categories', 'selectedCategory'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'boolean'
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sku' => $request->sku,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'weight' => $request->weight,
            'dimensions' => $request->dimensions,
            'material' => $request->material,
            'color' => $request->color,
            'active' => $request->has('active'),
        ];

        // Upload da imagem principal
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Otimiza a imagem antes de salvar
            $optimizedImage = ImageHelper::resizeAndOptimize($image, 800, 600, 85);
            if ($optimizedImage) {
                $imageName = time() . '_' . Str::slug($request->name) . '.' . $optimizedImage->getClientOriginalExtension();
                $imagePath = $optimizedImage->storeAs('products', $imageName, 'public');
                $data['image'] = $imagePath;
            }
        }

        $product = Product::create($data);

        // Upload de imagens adicionais
        if ($request->hasFile('images')) {
            $additionalImages = [];
            foreach ($request->file('images') as $index => $image) {
                // Otimiza cada imagem adicional
                $optimizedImage = ImageHelper::resizeAndOptimize($image, 800, 600, 85);
                if ($optimizedImage) {
                    $imageName = time() . '_' . $index . '_' . Str::slug($request->name) . '.' . $optimizedImage->getClientOriginalExtension();
                    $imagePath = $optimizedImage->storeAs('products', $imageName, 'public');
                    $additionalImages[] = $imagePath;
                }
            }
            $product->update(['images' => $additionalImages]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Produto criado com sucesso!');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load('category');
        
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('active', true)->orderBy('name')->get();
        
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'active' => 'boolean'
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'sku' => $request->sku,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'weight' => $request->weight,
            'dimensions' => $request->dimensions,
            'material' => $request->material,
            'color' => $request->color,
            'active' => $request->has('active'),
        ];

        // Upload da nova imagem principal
        if ($request->hasFile('image')) {
            // Deletar imagem anterior se existir
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('products', $imageName, 'public');
            $data['image'] = $imagePath;
        }

        // Upload de novas imagens adicionais
        if ($request->hasFile('images')) {
            // Deletar imagens anteriores se existirem
            if ($product->images && is_array($product->images)) {
                foreach ($product->images as $oldImage) {
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }

            $additionalImages = [];
            foreach ($request->file('images') as $index => $image) {
                $imageName = time() . '_' . $index . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('products', $imageName, 'public');
                $additionalImages[] = $imagePath;
            }
            $data['images'] = $additionalImages;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Deletar imagem principal se existir
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Deletar imagens adicionais se existirem
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
}
