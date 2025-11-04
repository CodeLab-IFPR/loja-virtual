<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Listar todos os produtos favoritos do usuário
     */
    public function index()
    {
        $favorites = Auth::user()->favoriteProducts()
            ->with('category')
            ->where('active', true)
            ->paginate(12);

        return view('favorites.index', compact('favorites'));
    }

    /**
     * Adicionar/Remover produto dos favoritos (toggle)
     */
    public function toggle($id)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuário não autenticado',
            ], 401);
        }

        // Busca o produto pelo ID
        $product = Product::findOrFail($id);

        $favorite = Favorite::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($favorite) {
            // Se já existe, remove (desfavoritar)
            $favorite->delete();
            $isFavorited = false;
            $message = 'Produto removido dos favoritos!';
        } else {
            // Se não existe, adiciona (favoritar)
            Favorite::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
            $isFavorited = true;
            $message = 'Produto adicionado aos favoritos!';
        }

        // Log para debug
        \Log::info('Favorito toggle', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'is_favorited' => $isFavorited,
        ]);

        // Se for requisição AJAX, retorna JSON
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'isFavorited' => $isFavorited,
                'message' => $message,
            ]);
        }

        // Se não for AJAX, redireciona com mensagem
        return back()->with('success', $message);
    }

    /**
     * Remover produto dos favoritos
     */
    public function destroy(Product $product)
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Produto removido dos favoritos!');
        }

        return back()->with('error', 'Produto não encontrado nos favoritos.');
    }
}
