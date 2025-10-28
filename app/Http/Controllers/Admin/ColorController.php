<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ColorController extends Controller
{
    /**
     * Display a listing of colors.
     */
    public function index(Request $request)
    {
        $query = Color::query();

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

        $colors = $query->orderBy('name')->paginate(15);

        $stats = [
            'total' => Color::count(),
            'active' => Color::where('active', true)->count(),
            'inactive' => Color::where('active', false)->count(),
        ];

        return view('admin.colors.index', compact('colors', 'stats'));
    }

    /**
     * Show the form for creating a new color.
     */
    public function create()
    {
        return view('admin.colors.create');
    }

    /**
     * Store a newly created color in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:colors,name',
            'description' => 'nullable|string|max:1000',
            'active' => 'boolean'
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'active' => $request->has('active'),
        ];

        Color::create($data);

        return redirect()->route('admin.colors.index')
            ->with('success', 'Cor criada com sucesso!');
    }

    /**
     * Display the specified color.
     */
    public function show(Color $color)
    {
        $color->load('products'); // Pode dar erro, já que não tem nada atrelado

        return view('admin.colors.show', compact('color'));
    }

    /**
     * Show the form for editing the specified color.
     */
    public function edit(Color $color)
    {
        return view('admin.colors.edit', compact('color'));
    }

    /**
     * Update the specified color in storage.
     */
    public function update(Request $request, Color $color)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:colors,name,' . $color->id,
            'description' => 'nullable|string|max:1000',
            'active' => 'boolean'
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'active' => $request->has('active'),
        ];

        $color->update($data);

        return redirect()->route('admin.colors.index')
            ->with('success', 'Cor atualizada com sucesso!');
    }

    /**
     * Remove the specified color from storage.
     */
    public function destroy(Color $color)
    {
        // Verificar se a cor tem produtos
        if ($color->products()->count() > 0) {
            return redirect()->route('admin.colors.index')
                ->with('error', 'Não é possível excluir uma cor que possui produtos.');
        }

        $color->delete();

        return redirect()->route('admin.colors.index')
            ->with('success', 'Cor excluída com sucesso!');
    }

    /**
     * Toggle color status (active/inactive).
     */
    public function toggleStatus(Color $color)
    {
        $color->update(['active' => !$color->active]);

        $status = $color->active ? 'ativada' : 'desativada';
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Cor {$status} com sucesso!",
                'active' => $color->active
            ]);
        }

        return redirect()->back()->with('success', "Cor {$status} com sucesso!");
    }
}
