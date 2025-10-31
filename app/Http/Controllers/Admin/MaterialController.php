<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MaterialController extends Controller
{
    /**
     * Display a listing of materials.
     */
    public function index(Request $request)
    {
        $query = Material::query();

        // Busca por nome ou descrição
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filtro por status
        if ($request->has('active') && $request->active !== '') {
            $query->where('active', $request->active === '1');
        }

        $materials = $query->orderBy('name')->paginate(15);

        $stats = [
            'total' => Material::count(),
            'active' => Material::where('active', true)->count(),
            'inactive' => Material::where('active', false)->count(),
        ];

        return view('admin.materials.index', compact('materials', 'stats'));
    }

    /**
     * Show the form for creating a new material.
     */
    public function create()
    {
        return view('admin.materials.create');
    }

    /**
     * Store a newly created material in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:materials,name',
            'description' => 'nullable|string|max:1000',
            'active' => 'boolean'
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'active' => $request->has('active'),
        ];

        Material::create($data);

        return redirect()->route('admin.materials.index')
            ->with('success', 'Material criada com sucesso!');
    }

    /**
     * Display the specified material.
     */
    public function show(Material $material)
    {
        $material->load('products'); // Pode dar erro, já que não tem nada atrelado

        return view('admin.materials.show', compact('material'));
    }

    /**
     * Show the form for editing the specified material.
     */
    public function edit(Material $material)
    {
        return view('admin.materials.edit', compact('material'));
    }

    /**
     * Update the specified material in storage.
     */
    public function update(Request $request, Material $material)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:materials,name,' . $material->id,
            'description' => 'nullable|string|max:1000',
            'active' => 'boolean'
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'active' => $request->has('active'),
        ];

        $material->update($data);

        return redirect()->route('admin.materials.index')
            ->with('success', 'Material atualizada com sucesso!');
    }

    /**
     * Remove the specified material from storage.
     */
    public function destroy(Material $material)
    {
        // Verificar se a material tem produtos
        if ($material->products()->count() > 0) {
            return redirect()->route('admin.materials.index')
                ->with('error', 'Não é possível excluir uma material que possui produtos.');
        }

        $material->delete();

        return redirect()->route('admin.materials.index')
            ->with('success', 'Material excluída com sucesso!');
    }

    /**
     * Toggle material status (active/inactive).
     */
    public function toggleStatus(Material $material)
    {
        $material->update(['active' => !$material->active]);

        $status = $material->active ? 'ativada' : 'desativada';
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Material {$status} com sucesso!",
                'active' => $material->active
            ]);
        }

        return redirect()->back()->with('success', "Material {$status} com sucesso!");
    }
}
