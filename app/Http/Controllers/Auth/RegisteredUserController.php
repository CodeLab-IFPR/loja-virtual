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
        'name'         => ['required', 'string', 'max:255'],
        'trading_name' => ['nullable', 'string', 'max:255'],
        'contact_name' => ['required', 'string', 'max:255'],
        'city'         => ['required', 'string', 'max:100'],
        'phone'        => ['required', 'string', 'max:20'],
        'email'        => ['required', 'string', 'lowercase', 'email:rfc,dns', 'max:255', 'unique:'.User::class],
        'password'     => [
            'required',
            'confirmed',
            Rules\Password::min(8)->max(20)->numbers()->symbols(),
            'regex:/[A-Z]/',
        ],
    ], [
        'name.required'         => 'O nome / razão social é obrigatório.',
        'contact_name.required' => 'O nome do responsável é obrigatório.',
        'city.required'         => 'A cidade é obrigatória.',
        'phone.required'        => 'O telefone é obrigatório.',
        'email.required'        => 'O e-mail é obrigatório.',
        'email.email'           => 'Informe um e-mail válido.',
        'email.unique'          => 'Este e-mail já está em uso.',
        'password.required'     => 'A senha é obrigatória.',
        'password.confirmed'    => 'As senhas não coincidem.',
        'password.min'          => 'A senha deve ter pelo menos 8 caracteres.',
        'password.max'          => 'A senha deve ter no máximo 20 caracteres.',
        'password.numbers'      => 'A senha deve conter pelo menos um número.',
        'password.symbols'      => 'A senha deve conter pelo menos um caractere especial (ex: !@#$%).',
        'password.regex'        => 'A senha deve conter pelo menos uma letra maiúscula.',
    ]);

    $user = User::create([
        'name'         => $request->name,
        'trading_name' => $request->trading_name,
        'contact_name' => $request->contact_name,
        'phone'        => $request->phone,
        'address'      => ['city' => $request->city],
        'email'        => $request->email,
        'password'     => Hash::make($request->password),
    ]);

    event(new Registered($user));

    return redirect()->route('login')->with('status', 'Cadastro realizado com sucesso. Aguarde a aprovação do administrador para acessar o sistema.');
}
}
