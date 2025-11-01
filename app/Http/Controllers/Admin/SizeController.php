<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SizeController extends Controller
{
    /**
     * Display a listing of sizes.
     */
    public function index(Request $request)
    {
        $query = Size::query();

        // Busca por nome ou descrição
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtro por status
        if ($request->has('active') && $request->active !== '') {
            $query->where('active', $request->active === '1');
        }

        $sizes = $query->orderBy('sort_order')->paginate(15);

        $stats = [
            'total' => Size::count(),
            'active' => Size::where('active', true)->count(),
            'inactive' => Size::where('active', false)->count(),
        ];

        return view('admin.sizes.index', compact('sizes', 'stats'));
    }

    /**
     * Show the form for creating a new size.
     */
    public function create()
    {
        return view('admin.sizes.create');
    }

    /**
     * Store a newly created size in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sizes,name',
            'description' => 'nullable|string|max:1000',
            'active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        Size::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'active' => $request->has('active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.sizes.index')
            ->with('success', 'Tamanho criado com sucesso!');
    }

    /**
     * Display the specified size.
     */
    public function show(Size $size)
    {
        return view('admin.sizes.show', compact('size'));
    }

    /**
     * Show the form for editing the specified size.
     */
    public function edit(Size $size)
    {
        return view('admin.sizes.edit', compact('size'));
    }

    /**
     * Update the specified size in storage.
     */
    public function update(Request $request, Size $size)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sizes,name,' . $size->id,
            'description' => 'nullable|string|max:1000',
            'active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        $size->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'active' => $request->has('active'),
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.sizes.index')
            ->with('success', 'Tamanho atualizado com sucesso!');
    }

    /**
     * Remove the specified size from storage.
     */
    public function destroy(Size $size)
    {
        $size->delete();

        return redirect()->route('admin.sizes.index')
            ->with('success', 'Tamanho excluído com sucesso!');
    }

    /**
     * Toggle size status (active/inactive).
     */
    public function toggleStatus(Size $size)
    {
        $size->update(['active' => !$size->active]);

        $status = $size->active ? 'ativado' : 'desativado';

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Tamanho {$status} com sucesso!",
                'active' => $size->active
            ]);
        }

        return redirect()->back()->with('success', "Tamanho {$status} com sucesso!");
    }
}
