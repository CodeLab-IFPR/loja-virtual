<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cadastro — {{ config('app.name', 'Shalom') }}</title>

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
    <div class="hidden lg:flex lg:w-2/5 bg-[#062035] flex-col items-center justify-center px-16 relative overflow-hidden">
        <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-white/5"></div>
        <div class="absolute -bottom-32 -right-20 w-[28rem] h-[28rem] rounded-full bg-white/5"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[32rem] h-[32rem] rounded-full border border-white/10"></div>

        <div class="relative z-10 text-center">
            <img src="{{ asset('images/icons/Logo_shalom.png') }}" alt="Shalom Vasos" class="mx-auto w-48 h-auto mb-10" style="filter: brightness(0) invert(1);">
            <h2 class="text-3xl font-bold text-white mb-3 tracking-tight">Bem-vindo!</h2>
            <p class="text-white/60 text-base max-w-xs mx-auto leading-relaxed">
                Crie sua conta e tenha acesso ao nosso catálogo exclusivo com preços e condições especiais.
            </p>
            <div class="mt-10 grid grid-cols-3 gap-6 text-center">
                <div>
                    <div class="text-white/90 text-2xl font-bold">500+</div>
                    <div class="text-white/50 text-xs mt-1 uppercase tracking-wider">Produtos</div>
                </div>
                <div class="border-x border-white/10 px-4">
                    <div class="text-white/90 text-2xl font-bold">50+</div>
                    <div class="text-white/50 text-xs mt-1 uppercase tracking-wider">Categorias</div>
                </div>
                <div>
                    <div class="text-white/90 text-2xl font-bold">24h</div>
                    <div class="text-white/50 text-xs mt-1 uppercase tracking-wider">Suporte</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Painel direito — formulário -->
    <div class="w-full lg:w-3/5 flex flex-col items-center justify-center px-6 sm:px-12 py-12 overflow-y-auto">

        <!-- Logo mobile -->
        <div class="lg:hidden mb-8">
            <img src="{{ asset('images/icons/Logo_shalom.png') }}" alt="Shalom Vasos" class="h-20 w-auto mx-auto">
        </div>

        <div class="w-full max-w-lg">
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-1">Criar nova conta</h1>
                <p class="text-sm text-gray-500">Preencha os dados abaixo para solicitar acesso</p>
            </div>

            @if($errors->any())
            <div class="mb-5 p-3 rounded-lg bg-red-50 border border-red-200 text-sm text-red-700 flex items-start gap-2">
                <i class="fas fa-circle-exclamation mt-0.5 shrink-0"></i>
                <ul class="space-y-0.5">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5" x-data="{ showPassword: false, showConfirm: false }">
                @csrf

                <!-- Seção: Dados da Empresa -->
                <div class="space-y-1 pb-1">
                    <p class="text-xs font-semibold text-[#062035] uppercase tracking-wider">Dados da Empresa</p>
                    <div class="h-px bg-gray-200"></div>
                </div>

                <!-- Nome / Razão Social -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nome / Razão Social <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-building text-gray-400 text-sm"></i>
                        </div>
                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                               required autofocus autocomplete="organization"
                               placeholder="Ex: Shalom Vasos Ltda."
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#062035]/40 focus:border-[#062035] transition {{ $errors->has('name') ? 'border-red-400 bg-red-50' : '' }}">
                    </div>
                </div>

                <!-- Nome Fantasia -->
                <div>
                    <label for="trading_name" class="block text-sm font-medium text-gray-700 mb-1.5">Nome Fantasia</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-store text-gray-400 text-sm"></i>
                        </div>
                        <input id="trading_name" type="text" name="trading_name" value="{{ old('trading_name') }}"
                               autocomplete="off"
                               placeholder="Ex: Shalom Vasos"
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#062035]/40 focus:border-[#062035] transition">
                    </div>
                </div>

                <!-- Linha: Contato + Cidade -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-1.5">Responsável / Contato <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <i class="fas fa-user text-gray-400 text-sm"></i>
                            </div>
                            <input id="contact_name" type="text" name="contact_name" value="{{ old('contact_name') }}"
                                   required autocomplete="name"
                                   placeholder="Nome do responsável"
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#062035]/40 focus:border-[#062035] transition {{ $errors->has('contact_name') ? 'border-red-400 bg-red-50' : '' }}">
                        </div>
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1.5">Cidade <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <i class="fas fa-map-marker-alt text-gray-400 text-sm"></i>
                            </div>
                            <input id="city" type="text" name="city" value="{{ old('city') }}"
                                   required autocomplete="address-level2"
                                   placeholder="Ex: São Paulo"
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#062035]/40 focus:border-[#062035] transition {{ $errors->has('city') ? 'border-red-400 bg-red-50' : '' }}">
                        </div>
                    </div>
                </div>

                <!-- Seção: Contato -->
                <div class="space-y-1 pb-1 pt-2">
                    <p class="text-xs font-semibold text-[#062035] uppercase tracking-wider">Informações de Contato</p>
                    <div class="h-px bg-gray-200"></div>
                </div>

                <!-- Telefone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">Telefone <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400 text-sm"></i>
                        </div>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                               required autocomplete="tel"
                               placeholder="(00) 0 0000-0000"
                               oninput="formatPhone(event)"
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#062035]/40 focus:border-[#062035] transition {{ $errors->has('phone') ? 'border-red-400 bg-red-50' : '' }}">
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">E-mail <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400 text-sm"></i>
                        </div>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                               required autocomplete="username"
                               placeholder="seu@email.com"
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#062035]/40 focus:border-[#062035] transition {{ $errors->has('email') ? 'border-red-400 bg-red-50' : '' }}">
                    </div>
                </div>

                <!-- Seção: Acesso -->
                <div class="space-y-1 pb-1 pt-2">
                    <p class="text-xs font-semibold text-[#062035] uppercase tracking-wider">Dados de Acesso</p>
                    <div class="h-px bg-gray-200"></div>
                </div>

                <!-- Senha -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Senha <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 text-sm"></i>
                        </div>
                        <input id="password" :type="showPassword ? 'text' : 'password'" name="password"
                               required autocomplete="new-password" placeholder="••••••••"
                               class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#062035]/40 focus:border-[#062035] transition {{ $errors->has('password') ? 'border-red-400 bg-red-50' : '' }}">
                        <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition">
                            <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                        </button>
                    </div>
                    <p class="mt-1.5 text-xs text-gray-400">Mín. 8 caracteres, incluindo número, maiúscula e símbolo.</p>
                </div>

                <!-- Confirmar Senha -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Confirmar Senha <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400 text-sm"></i>
                        </div>
                        <input id="password_confirmation" :type="showConfirm ? 'text' : 'password'" name="password_confirmation"
                               required autocomplete="new-password" placeholder="••••••••"
                               class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#062035]/40 focus:border-[#062035] transition">
                        <button type="button" @click="showConfirm = !showConfirm"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 transition">
                            <i :class="showConfirm ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Botões -->
                <div class="flex gap-3 pt-2">
                    <a href="{{ route('login') }}"
                       class="w-1/3 py-2.5 px-4 bg-white text-gray-700 text-sm font-semibold rounded-lg border border-gray-300 hover:bg-gray-50 hover:border-gray-400 focus:outline-none transition flex items-center justify-center gap-2">
                        <i class="fas fa-arrow-left text-xs"></i> Voltar
                    </a>
                    <button type="submit"
                            class="flex-1 py-2.5 px-4 bg-[#062035] text-white text-sm font-semibold rounded-lg hover:bg-[#0a3360] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#062035] transition">
                        Solicitar Cadastro
                    </button>
                </div>
            </form>
        </div>

        <p class="mt-10 text-xs text-gray-400">© {{ date('Y') }} Shalom Vasos Ltda. Todos os direitos reservados.</p>
    </div>
</div>

<script>
function formatPhone(event) {
    let input = event.target;
    let value = input.value.replace(/\D/g, '');
    let formatted = '';
    if (value.length > 0) formatted = '(' + value.substring(0, 2);
    if (value.length > 2) formatted += ') ' + value.substring(2, 3);
    if (value.length > 3) formatted += ' ' + value.substring(3, 7);
    if (value.length > 7) formatted += '-' + value.substring(7, 11);
    if (value.length > 11) value = value.substring(0, 11);
    input.value = formatted;
}
</script>
</body>
</html>
