<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — {{ config('app.name', 'Shalom') }}</title>

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
        <!-- Círculos decorativos -->
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-white/5"></div>
        <div class="absolute -bottom-32 -right-20 w-[28rem] h-[28rem] rounded-full bg-white/5"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[32rem] h-[32rem] rounded-full border border-white/10"></div>

        <div class="relative z-10 text-center">
            <img src="{{ asset('images/icons/Logo_shalom.png') }}" alt="Shalom Vasos" class="mx-auto w-56 h-auto mb-10" style="filter: brightness(0) invert(1);">
            <h2 class="text-3xl font-bold text-white mb-3 tracking-tight">Portal de Vendas</h2>
            <p class="text-white/60 text-base max-w-xs mx-auto leading-relaxed">
                Acesse nosso catálogo exclusivo de vasos artesanais com preços e condições especiais.
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
              <!--   <div>
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
            <img src="{{ asset('images/icons/Logo_shalom.png') }}" alt="Shalom Vasos" class="h-29 w-auto mx-auto">
        </div>

        <div class="w-full max-w-sm">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Bem-vindo de volta</h1>
                <p class="text-sm text-gray-500">Faça login para acessar sua conta</p>
            </div>

            <!-- Status -->
            @if(session('status'))
            <div class="mb-4 p-4 rounded-lg bg-green-50 border border-green-200 text-sm text-green-700 flex items-start gap-3">
                <i class="fas fa-circle-check mt-0.5 shrink-0 text-green-500"></i>
                <span>Sua senha foi redefinida com sucesso. Faça login com sua nova senha.</span>
            </div>
            @endif

            <!-- Erros gerais -->
            @if($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-sm text-red-700 flex items-start gap-2">
                <i class="fas fa-circle-exclamation mt-0.5 shrink-0"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4" x-data="{ showPassword: false }">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">E-mail</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400 text-sm"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required autofocus autocomplete="username"
                               placeholder="seu@email.com"
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#062035]/40 focus:border-[#062035] transition {{ $errors->get('email') ? 'border-red-400 bg-red-50' : '' }}">
                    </div>
                </div>

                <!-- Senha -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-[#062035] hover:underline font-medium">
                            Esqueceu a senha?
                        </a>
                        @endif
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 text-sm"></i>
                        </div>
                        <input id="password" :type="showPassword ? 'text' : 'password'" name="password"
                               required autocomplete="current-password" placeholder="••••••••"
                               class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#062035]/40 focus:border-[#062035] transition {{ $errors->get('password') ? 'border-red-400 bg-red-50' : '' }}">
                        <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition">
                            <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Lembre-me -->
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                           class="w-4 h-4 rounded border-gray-300 text-[#062035] focus:ring-[#062035]/30">
                    <label for="remember_me" class="ml-2 text-sm text-gray-600">Manter conectado</label>
                </div>

                <!-- Botão entrar -->
                <button type="submit"
                        class="w-full py-2.5 px-4 bg-[#062035] text-white text-sm font-semibold rounded-lg hover:bg-[#0a3360] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#062035] transition">
                    Entrar
                </button>

                @if (Route::has('register'))
                <div class="relative my-1">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="px-3 bg-gray-50 text-xs text-gray-400">ou</span>
                    </div>
                </div>

                <a href="{{ route('register') }}"
                   class="w-full py-2.5 px-4 bg-white text-gray-700 text-sm font-semibold rounded-lg border border-gray-300 hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition flex items-center justify-center gap-2">
                    <i class="fas fa-user-plus text-gray-500 text-xs"></i>
                    Criar nova conta
                </a>
                @endif
            </form>
        </div>

        <p class="mt-12 text-xs text-gray-400">© {{ date('Y') }} Shalom Vasos Ltda. Todos os direitos reservados.</p>
    </div>
</div>
</body>
</html>