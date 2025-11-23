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

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col bg-gray-100 ">
        <div
            class="flex-grow flex flex-col sm:justify-center items-center pt-6 sm:pt-0 {{ isset($hideFooter) && $hideFooter ? 'pb-6' : '' }}">
            <div>
                <a href="/">
                    <img class="h-auto w-[19rem]" src="{{ asset('images/icons/Logo_shalom.png') }}"
                        alt="Logotipo Shalom Vasos Decor">
                </a>
            </div>

            <div
                class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>

        <!-- Ariel: Tirei depois ver se é necessário voltar -->
        <!-- @unless(isset($hideFooter) && $hideFooter) -->
        <!-- Footer -->
        <!-- @include('layouts.footer') -->
        <!-- @endunless -->
    </div>
</body>

</html>