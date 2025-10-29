<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
 public function store(Request $request): RedirectResponse
{
    $request->merge(['email' => strtolower($request->email)]);
    
    $request->validate([
        'name' => ['required', 'string', 'min:4', 'max:15'],
        'email' => ['required', 'string', 'lowercase', 'email:rfc,dns', 'max:255', 'unique:'.User::class],
        'password' => [
            'required',
            'confirmed',
            Rules\Password::min(8)
                ->max(20)
                ->numbers()
                ->symbols(),
            'regex:/[A-Z]/', // Garante ao menos 1 letra maiúscula (sem exigir minúscula)
        ],
    ], [
        'name.required' => 'O usuário é obrigatório.',
        'name.string' => 'O usuário deve ser uma string.',
        'name.min' => 'O usuário deve ter pelo menos 4 caracteres.',
        'name.max' => 'O usuário deve ter no máximo 15 caracteres.',
        
        'email.required' => 'O email é obrigatório.',
        'email.email' => 'O email deve ser um endereço válido.',
        'email.max' => 'O email deve ter no máximo 255 caracteres.',
        'email.unique' => 'Este email já está em uso.',
        
        'password.required' => 'A senha é obrigatória.',
        'password.confirmed' => 'As senhas não coincidem.',
        'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
        'password.max' => 'A senha deve ter no máximo 20 caracteres.',
        'password.numbers' => 'A senha deve conter pelo menos um número.',
        'password.symbols' => 'A senha deve conter pelo menos um caractere especial (ex: !@#$%).',
        'password.regex' => 'A senha deve conter pelo menos uma letra maiúscula.',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));

    return redirect()->route('login')->with('status', 'Cadastro realizado com sucesso. Faça login para continuar.');
}
}
