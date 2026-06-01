<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminAdminController extends Controller
{
    /**
     * Lista todos os usuários administradores.
     */
    public function index(Request $request)
    {
        $query = User::where('user_type', 'admin');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $admins = $query->orderBy('created_at', 'desc')->paginate(15);

        $total = User::where('user_type', 'admin')->count();

        return view('admin.admins.index', compact('admins', 'total'));
    }

    /**
     * Exibe o formulário de criação.
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Persiste um novo administrador.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'user_type'      => 'admin',
            'status'         => 'approved',
            'can_see_prices' => true,
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Administrador criado com sucesso!');
    }

    /**
     * Exibe o formulário de edição.
     */
    public function edit(User $admin)
    {
        if ($admin->user_type !== 'admin') {
            return redirect()->route('admin.admins.index')
                ->with('error', 'Usuário não encontrado.');
        }

        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Atualiza um administrador existente.
     */
    public function update(Request $request, User $admin)
    {
        if ($admin->user_type !== 'admin') {
            return redirect()->route('admin.admins.index')
                ->with('error', 'Usuário não encontrado.');
        }

        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $admin->id],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Password::min(8)];
        }

        $request->validate($rules);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Administrador atualizado com sucesso!');
    }

    /**
     * Exclui um administrador.
     */
    public function destroy(User $admin)
    {
        if ($admin->user_type !== 'admin') {
            return redirect()->route('admin.admins.index')
                ->with('error', 'Usuário não encontrado.');
        }

        if ($admin->id === Auth::id()) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'Você não pode excluir o seu próprio usuário.');
        }

        $adminCount = User::where('user_type', 'admin')->count();
        if ($adminCount <= 1) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'Não é possível excluir o último administrador do sistema.');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Administrador excluído com sucesso.');
    }
}
