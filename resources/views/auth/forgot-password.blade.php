<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Recuperar Senha — {{ config('app.name', 'Shalom') }}</title>
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
            <h2 class="text-3xl font-bold text-white mb-3 tracking-tight">Recuperação de Senha</h2>
            <p class="text-white/60 text-base max-w-xs mx-auto leading-relaxed">
                Enviaremos um link seguro para você criar uma nova senha.
            </p>
            <div class="mt-12 grid grid-cols-3 gap-6 text-center">
                <div>
                    <div class="text-white/90 text-2xl font-bold">50+</div>
                    <div class="text-white/50 text-xs mt-1 uppercase tracking-wider">Produtos</div>
                </div>
                <div class="border-x border-white/10 px-4">
                    <div class="text-white/90 text-2xl font-bold">10+</div>
                    <div class="text-white/50 text-xs mt-1 uppercase tracking-wider">Categorias</div>
                </div>
               <!--  <div>
                    <div class="text-white/90 text-2xl font-bold">24h</div>
                    <div class="text-white/50 text-xs mt-1 uppercase tracking-wider">Suporte</div>
                </div> -->
            </div>
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
                    <i class="fas fa-lock text-[#062035] text-lg"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Esqueceu sua senha?</h1>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Informe seu e-mail e enviaremos um link para você criar uma nova senha.
                </p>
            </div>

            <!-- Status (link enviado) -->
            @if (session('status'))
            <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-sm text-green-700 flex items-start gap-3">
                <i class="fas fa-circle-check mt-0.5 shrink-0 text-green-500"></i>
                <span>Link de redefinição enviado! Verifique sua caixa de entrada.</span>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-sm text-red-700 flex items-start gap-2">
                <i class="fas fa-circle-exclamation mt-0.5 shrink-0"></i>
                <span>Não encontramos nenhuma conta com este e-mail.</span>
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4" x-data="{ loading: false }" @submit="loading = true">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">E-mail</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400 text-sm"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required autofocus autocomplete="email"
                               placeholder="seu@email.com"
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#062035]/40 focus:border-[#062035] transition {{ $errors->get('email') ? 'border-red-400 bg-red-50' : '' }}">
                    </div>
                </div>

                <button type="submit" :disabled="loading"
                        class="w-full py-2.5 px-4 bg-[#062035] text-white text-sm font-semibold rounded-lg hover:bg-[#0a3360] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#062035] transition flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                    <template x-if="!loading">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-paper-plane text-xs"></i>
                            Enviar link de redefinição
                        </span>
                    </template>
                    <template x-if="loading">
                        <span class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Enviando...
                        </span>
                    </template>
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
