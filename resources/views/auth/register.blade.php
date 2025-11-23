<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Average+Sans&family=Alexandria:wght@400&display=swap"
        rel="stylesheet">


    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        darkMode: 'class',
    }
    </script>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">


    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans text-gray-900 bg-[#F6F6F6] flex items-center justify-center min-h-screen antialiased">
    <div class="flex flex-col items-center w-full max-w-lg px-4 sm:px-6 md:px-8 space-y-6">

        <div class="text-center">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-normal text-gray-800 uppercase whitespace-nowrap"
                style="font-family: 'Average Sans', sans-serif;">CRIAR UMA CONTA</h1>
            <p class="mt-1 text-sm sm:text-base"
                style="font-family: 'Alexandria', sans-serif; font-weight:400; font-style:normal; text-align:center; text-transform:uppercase;">
                PREENCHA O FORMULÁRIO DE CADASTRO ABAIXO</p>
        </div>

        <div class="w-full p-4 sm:p-6 md:p-8 border border-black bg-[#F6F6F6] shadow-none rounded-2xl overflow-hidden">
            <img src="{{ asset('images/icons/Logo_shalom.png') }}" alt="Logo Shalom"
                class="mx-auto mb-4 w-32 sm:w-40 h-auto" />

            <form method="POST" action="{{ route('register') }}" class="mt-4 sm:mt-6 space-y-4">
                @csrf
                <div class="space-y-4">

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user h-5 w-5 text-black"></i>
                        </div>
                        <x-text-input id="name" name="name" :value="old('name')"
                            class="block w-full pl-10 py-2 sm:py-3  border border-black rounded-md placeholder-black focus:border-black dark:focus:border-black focus:ring-black dark:focus:ring-black"
                            required autofocus autocomplete="name" placeholder="Usuário" />
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone h-5 w-5 text-black"></i>
                        </div>
                        <x-text-input id="phone" name="phone" :value="old('phone')"
                            class="block w-full pl-10 py-2 sm:py-3  border border-black rounded-md placeholder-black focus:border-black dark:focus:border-black focus:ring-black dark:focus:ring-black"
                            type="tel" required autocomplete="tel" placeholder="Telefone"
                            oninput="formatPhone(event)" />
                    </div>
                    <x-input-error :messages="$errors->get('phone')" class="mt-2 text-sm text-red-600" />

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope h-5 w-5 text-black"></i>
                        </div>
                        <x-text-input id="email" name="email" :value="old('email')"
                            class="block w-full pl-10 py-2 sm:py-3  border border-black rounded-md placeholder-black focus:border-black dark:focus:border-black focus:ring-black dark:focus:ring-black"
                            type="email" required autocomplete="username" placeholder="Email" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />

                    <div class="relative" x-data="{ show: false }">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-key h-5 w-5 text-black"></i>
                        </div>
                        <x-text-input id="password" name="password"
                            class="block w-full pl-10 py-2 sm:py-3  border border-black rounded-md placeholder-black focus:border-black dark:focus:border-black focus:ring-black dark:focus:ring-black"
                            x-bind:type="show ? 'text' : 'password'" required autocomplete="new-password"
                            placeholder="Senha" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" @click="show = !show"
                                class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <template x-if="!show">
                                    <i class="fas fa-eye h-5 w-5 text-black"></i>
                                </template>
                                <template x-if="show">
                                    <i class="fas fa-eye-slash h-5 w-5 text-black"></i>
                                </template>
                            </button>
                        </div>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class=" text-sm text-red-600" />
                    <div class="text-sm text-gray-600">
                        <p><strong>Regras para a senha:</strong></p>
                        <ul class="list-disc pl-5">
                            <li>Ao menos 8 e no máximo 20 caracteres.</li>
                            <li>Ao menos 1 número.</li>
                            <li>Ao menos 1 caractere especial (ex: !@#$%).</li>
                            <li>Ao menos 1 letra maiúscula.</li>
                        </ul>
                    </div>

                    <div class="relative" x-data="{ showConfirm: false }">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-key h-5 w-5 text-black"></i>
                        </div>
                        <x-text-input id="password_confirmation" name="password_confirmation"
                            class="block w-full pl-10 py-2 sm:py-3  border border-black rounded-md placeholder-black focus:border-black dark:focus:border-black focus:ring-black dark:focus:ring-black"
                            x-bind:type="showConfirm ? 'text' : 'password'" required autocomplete="new-password"
                            placeholder="Confirmar Senha" />
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" @click="showConfirm = !showConfirm"
                                class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                <template x-if="!showConfirm">
                                    <i class="fas fa-eye h-5 w-5 text-black"></i>
                                </template>
                                <template x-if="showConfirm">
                                    <i class="fas fa-eye-slash h-5 w-5 text-black"></i>
                                </template>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')"
                            class="mt-2 text-sm text-red-600" />
                    </div>

                    <div class="flex flex-col sm:flex-row w-full mt-3 gap-2">
                        <a href="{{ route('login') }}"
                            class="w-full sm:w-1/2 text-center py-2 px-4 text-base bg-[#e9e9e9] text-gray-900 font-bold rounded-md hover:bg-[#c9c9c9]focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 shadow-md shadow-black/20">
                            Voltar
                        </a>
                        <button type="submit"
                            class="w-full sm:w-1/2 text-center py-2 px-4 text-base bg-[rgba(6,32,53,1)] text-white font-bold rounded-md hover:bg-[rgba(6,32,53,0.8)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 shadow-md shadow-black/20">
                            Cadastrar
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="text-center text-sm text-gray-600 mt-4">
            SHALOM VASOS LTDA.
        </div>
    </div>
    <script>
    function formatPhone(event) {
        let input = event.target;
        let value = input.value.replace(/\D/g, '');
        let formatted = '';
        if (value.length > 0) {
            formatted = '(' + value.substring(0, 2);
        }
        if (value.length > 2) {
            formatted += ') ' + value.substring(2, 3);
        }
        if (value.length > 3) {
            formatted += ' ' + value.substring(3, 7);
        }
        if (value.length > 7) {
            formatted += '-' + value.substring(7, 11);
        }
        if (value.length > 11) {
            value = value.substring(0, 11);
        }
        input.value = formatted;
    }
    </script>
</body>

</html>