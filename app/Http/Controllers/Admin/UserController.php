<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::where('user_type', 'customer');

        // Filtro por status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Busca por nome ou email
        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'total' => User::where('user_type', 'customer')->count(),
            'pending' => User::where('user_type', 'customer')->where('status', 'pending')->count(),
            'approved' => User::where('user_type', 'customer')->where('status', 'approved')->count(),
            'rejected' => User::where('user_type', 'customer')->where('status', 'rejected')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        // Verificar se é um cliente
        if ($user->user_type !== 'customer') {
            return redirect()->route('admin.users.index')
                ->with('error', 'Usuário não encontrado.');
        }

        return view('admin.users.show', compact('user'));
    }

    /**
     * Approve a customer.
     */
    public function approve(User $user)
    {
        if ($user->user_type !== 'customer') {
            return response()->json(['error' => 'Usuário inválido'], 400);
        }

        DB::transaction(function () use ($user) {
            $user->update([
                'status' => 'approved',
                'can_see_prices' => true,
                'approved_at' => now(),
                'approved_by' => Auth::id(),
            ]);
        });

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cliente aprovado com sucesso!'
            ]);
        }

        return redirect()->back()->with('success', 'Cliente aprovado com sucesso!');
    }

    /**
     * Reject a customer.
     */
    public function reject(User $user)
    {
        if ($user->user_type !== 'customer') {
            return response()->json(['error' => 'Usuário inválido'], 400);
        }

        DB::transaction(function () use ($user) {
            $user->update([
                'status' => 'rejected',
                'can_see_prices' => false,
                'approved_at' => null,
                'approved_by' => null,
            ]);
        });

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cliente rejeitado.'
            ]);
        }

        return redirect()->back()->with('warning', 'Cliente rejeitado.');
    }

    /**
     * Bulk actions for multiple users.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'users' => 'required|array',
            'users.*' => 'exists:users,id'
        ]);

        $users = User::whereIn('id', $request->users)
                    ->where('user_type', 'customer')
                    ->get();

        $count = 0;
        DB::transaction(function () use ($users, $request, &$count) {
            foreach ($users as $user) {
                if ($request->action === 'approve') {
                    $user->update([
                        'status' => 'approved',
                        'can_see_prices' => true,
                        'approved_at' => now(),
                        'approved_by' => Auth::id(),
                    ]);
                } else {
                    $user->update([
                        'status' => 'rejected',
                        'can_see_prices' => false,
                        'approved_at' => null,
                        'approved_by' => null,
                    ]);
                }
                $count++;
            }
        });

        $action_text = $request->action === 'approve' ? 'aprovados' : 'rejeitados';
        return redirect()->back()->with('success', "{$count} clientes {$action_text} com sucesso!");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Não implementado - clientes se cadastram pelo front-end
        return redirect()->route('admin.users.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Não implementado - clientes se cadastram pelo front-end
        return redirect()->route('admin.users.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Não implementado - apenas aprovação/rejeição
        return redirect()->route('admin.users.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Não implementado - apenas aprovação/rejeição
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Não implementado por segurança
        return redirect()->route('admin.users.index');
    }
}
