<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
            }
        </script>
        
        <!-- Font Awesome CDN -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans text-gray-900 bg-[#D9D9D9] flex items-center justify-center min-h-screen">
        <div class="flex flex-col items-center w-full max-w-lg px-8 space-y-4 rounded-lg">
            <!-- Cabeçalho acima do card -->
            <div class="text-center">
            <h1 class="text-6xl font-normal text-gray-800 uppercase whitespace-nowrap" style="font-family: 'Average Sans', sans-serif;">CRIAR UMA CONTA</h1>
            <p class="mt-1" style="font-family: 'Alexandria', sans-serif; font-weight:400; font-style:normal; text-align:center; text-transform:uppercase;">PREENCHA O FORMULÁRIO DE CADASTRO ABAIXO</p>
            </div>

            <!-- Card -->
            <div class="w-full p-8 border border-black bg-[#D9D9D9] shadow-none rounded-2xl overflow-hidden">
            <img src="{{ asset('storage/Logo_shalom.png') }}" alt="Logo Shalom" class="mx-auto mb-4 w-40 h-auto" />

            <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
                @csrf
                <div class="space-y-4">
                <!-- Usuário -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-user h-5 w-5 text-black"></i>
                    </div>
                    <x-text-input id="name" class="block w-full pl-10 py-2 bg-[#D9D9D9] border border-black rounded-md placeholder-black focus:border-black dark:focus:border-black focus:ring-black dark:focus:ring-black"  required autofocus autocomplete="name" placeholder="Usuário" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Telefone -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-phone h-5 w-5 text-black"></i>
                    </div>
                    <x-text-input id="phone" class="block w-full pl-10 py-2 bg-[#D9D9D9] border border-black rounded-md placeholder-black focus:border-black dark:focus:border-black focus:ring-black dark:focus:ring-black" type="tel" name="phone" :value="old('phone')" required autocomplete="tel" placeholder="Telefone" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Email -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope h-5 w-5 text-black"></i>
                    </div>
                    <x-text-input id="email" class="block w-full pl-10 py-2 bg-[#D9D9D9] border border-black rounded-md placeholder-black focus:border-black dark:focus:border-black focus:ring-black dark:focus:ring-black" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Senha -->
                <div class="relative" x-data="{ show: false }">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-key h-5 w-5 text-black"></i>
                    </div>
                    <x-text-input id="password" class="block w-full pl-10 py-2 bg-[#D9D9D9] border border-black rounded-md placeholder-black focus:border-black dark:focus:border-black focus:ring-black dark:focus:ring-black" x-bind:type="show ? 'text' : 'password'" name="password" required autocomplete="new-password" placeholder="Senha" />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <button type="button" @click="show = !show" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <template x-if="!show">
                        <i class="fas fa-eye h-5 w-5 text-black"></i>
                        </template>
                        <template x-if="show">
                        <i class="fas fa-eye-slash h-5 w-5 text-black"></i>
                        </template>
                    </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Confirmar Senha -->
                <div class="relative" x-data="{ showConfirm: false }">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-key h-5 w-5 text-black"></i>
                    </div>
                    <x-text-input id="password_confirmation" class="block w-full pl-10 py-2 bg-[#D9D9D9] border border-black rounded-md placeholder-black focus:border-black dark:focus:border-black focus:ring-black dark:focus:ring-black" x-bind:type="showConfirm ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar Senha" />
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <button type="button" @click="showConfirm = !showConfirm" class="text-gray-400 hover:text-gray-500 focus:outline-none">
                        <template x-if="!showConfirm">
                        <i class="fas fa-eye h-5 w-5 text-black"></i>
                        </template>
                        <template x-if="showConfirm">
                        <i class="fas fa-eye-slash h-5 w-5 text-black"></i>
                        </template>
                    </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
                </div>

                <!-- Botões -->
                <div class="flex w-full mt-3 gap-2">
                    <a href="{{ route('login') }}" class="w-[50%] text-center py-2 px-2 text-base bg-[#C7C5C5] text-gray-900 font-bold rounded-2xl   hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 shadow-md shadow-black/60">
                        Voltar
                    </a>
                    <button type="submit" class="w-[50%] text-center py-2 px-2 text-base bg-[#C7C5C5] text-gray-900 font-bold rounded-2xl hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 shadow-md shadow-black/60">
                        Cadastrar
                    </button>
                </div>
                </div>
            </form>
            </div>

            <!-- Texto abaixo do card -->
            <div class="text-center text-sm text-gray-600">
            SHALOM VASOS LTDA.
            </div>
        </div>
    </body>
</html>