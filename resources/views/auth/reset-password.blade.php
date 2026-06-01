<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Redefinir Senha — {{ config('app.name', 'Shalom') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50">
@include('layouts.navigation')
<div class="min-h-screen flex">

    <!-- Painel esquerdo — marca -->
    <div class="hidden lg:flex lg:w-1/2 bg-[#062035] flex-col items-center justify-center px-16 relative overflow-hidden">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-white/5"></div>
        <div class="absolute -bottom-32 -right-20 w-[28rem] h-[28rem] rounded-full bg-white/5"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[32rem] h-[32rem] rounded-full border border-white/10"></div>
        <div class="relative z-10 text-center">
            <img src="{{ asset('images/icons/Logo_shalom.png') }}" alt="Shalom Vasos" class="mx-auto w-56 h-auto mb-10" style="filter: brightness(0) invert(1);">
            <h2 class="text-3xl font-bold text-white mb-3 tracking-tight">Nova Senha</h2>
            <p class="text-white/60 text-base max-w-xs mx-auto leading-relaxed">
                Crie uma senha forte para proteger sua conta no portal.
            </p>
        </div>
    </div>

    <!-- Painel direito — formulário -->
    <div class="w-full lg:w-1/2 flex flex-col items-center justify-center px-6 sm:px-12 py-12">

        <!-- Logo mobile -->
        <div class="lg:hidden mb-8">
            <img src="{{ asset('images/icons/Logo_shalom.png') }}" alt="Shalom Vasos" class="h-20 w-auto mx-auto">
        </div>

        <div class="w-full max-w-sm">
            <div class="mb-8">
                <div class="w-12 h-12 bg-[#062035]/10 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-key text-[#062035] text-lg"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Redefinir senha</h1>
                <p class="text-sm text-gray-500">Escolha uma nova senha para sua conta.</p>
            </div>

            @if($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-sm text-red-700 flex items-start gap-2">
                <i class="fas fa-circle-exclamation mt-0.5 shrink-0"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}" class="space-y-4" x-data="{ showPassword: false, showConfirm: false }">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">E-mail</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400 text-sm"></i>
                        </div>
                        <input id="email" type="email" name="email"
                               value="{{ old('email', $request->email) }}"
                               required autocomplete="username"
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#062035]/40 focus:border-[#062035] transition {{ $errors->get('email') ? 'border-red-400 bg-red-50' : '' }}">
                    </div>
                    @error('email')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nova Senha -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Nova Senha</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 text-sm"></i>
                        </div>
                        <input id="password" :type="showPassword ? 'text' : 'password'" name="password"
                               required autocomplete="new-password" placeholder="Mínimo 8 caracteres"
                               class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#062035]/40 focus:border-[#062035] transition {{ $errors->get('password') ? 'border-red-400 bg-red-50' : '' }}">
                        <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition">
                            <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                        </button>
                    </div>
                    @error('password')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmar Senha -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirmar Senha</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 text-sm"></i>
                        </div>
                        <input id="password_confirmation" :type="showConfirm ? 'text' : 'password'"
                               name="password_confirmation"
                               required autocomplete="new-password" placeholder="Repita a nova senha"
                               class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#062035]/40 focus:border-[#062035] transition {{ $errors->get('password_confirmation') ? 'border-red-400 bg-red-50' : '' }}">
                        <button type="button" @click="showConfirm = !showConfirm"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition">
                            <i :class="showConfirm ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full py-2.5 px-4 bg-[#062035] text-white text-sm font-semibold rounded-lg hover:bg-[#0a3360] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#062035] transition flex items-center justify-center gap-2">
                    <i class="fas fa-check text-xs"></i>
                    Redefinir senha
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-[#062035] transition inline-flex items-center gap-1.5">
                    <i class="fas fa-arrow-left text-xs"></i>
                    Voltar ao login
                </a>
            </div>
        </div>

        <p class="mt-12 text-xs text-gray-400">© {{ date('Y') }} Shalom Vasos Ltda. Todos os direitos reservados.</p>
    </div>
</div>
</body>
</html>
