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
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-center items-center bg-[#D9D9D9]">
            <div class="w-[80%] max-w-7.1xl mx-[50px] my-[40px] px-8 py-12 bg-[#D9D9D9] shadow-2xl overflow-hidden rounded-none min-h-[70vh]">
                <div class="space-y-8 -mt-12">
                    <div class="text-center">
                        <img src="{{ asset('storage/Logo_shalom.png') }}" alt="Logo Shalom" class="mx-auto mb-1 w-72 h-auto" />
                        <h1 class="text-6xl font-normal text-gray-800 uppercase" style="font-family: 'Average Sans', sans-serif;">Seja Bem Vindo</h1>
                        <p class="mt-1" style="font-family: 'Alexandria', sans-serif; font-weight:400; font-style:normal; text-align:center; text-transform:uppercase;">
                            Forneça seus dados para login
                        </p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mt-6 mb-4 text-center" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="mt-6">
                        @csrf
                        <div class="w-full sm:w-[25%] mx-auto space-y-4">
                            <!-- Usuário (Email) -->
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user h-5 w-5 text-black"></i>
                                </div>
                                <x-text-input id="email" class="block w-full pl-10 py-2 bg-[#D9D9D9] border border-black rounded-md placeholder-black focus:border-black dark:focus:border-black focus:ring-black dark:focus:ring-black" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Usuário" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600 space-y-1" />

                            <!-- Senha -->
                            <div class="relative" x-data="{ show: false }">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-key h-5 w-5 text-black"></i>
                                </div>
                                <x-text-input id="password" class="block w-full pl-10 pr-10 py-2 bg-[#D9D9D9] border border-black rounded-md placeholder-black text-gray-900 focus:border-black dark:focus:border-black focus:ring-black dark:focus:ring-black" x-bind:type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="Senha" />
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
                                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600 space-y-1" />
                            </div>

                            <!-- Remember Me and Forgot Password -->
                            <div class="flex items-center justify-between mt-2 text-sm text-gray-600">
                                <label for="remember_me" class="flex items-center">
                                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-gray-600 shadow-sm focus:ring-gray-500" name="remember">
                                    <span class="ml-2">Lembre-me</span>
                                </label>

                                @if (Route::has('password.request'))
                                    <a class="hover:text-gray-900" href="{{ route('password.request') }}">
                                        Esqueceu sua senha?
                                    </a>
                                @endif
                            </div>

                            <div class="flex w-full mt-4 gap-[5px]">
                                <button type="submit" class="flex-1 text-center py-3 px-3 text-lg bg-[#C7C5C5] text-gray-900 font-bold rounded-xl hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    {{ __('Entrar') }}
                                </button>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="flex-1 text-center py-3 px-3 text-lg bg-[#C7C5C5] text-gray-900 font-bold rounded-xl hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                        {{ __('Cadastrar') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center text-sm text-gray-600 mb-4">
                Shalom Vasos Ltda.
            </div>
        </div>
    </body>
</html>