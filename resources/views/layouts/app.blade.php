<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('seo_title', config('app.name', 'Shalom Vasos Decor'))</title>
        <meta name="description" content="@yield('seo_description', 'Shalom Vasos Decor — fábrica de vasos de concreto e cimento em Nova Esperança, Paraná. Vasos artesanais para decoração, jardim e projetos especiais. Atacado e varejo.')">
        <meta name="keywords" content="@yield('seo_keywords', 'vasos de concreto, vasos de cimento, fábrica de vasos, Nova Esperança, Paraná, vasos artesanais, decoração, jardim, vasos atacado')">
        <meta name="robots" content="index, follow">
        <link rel="canonical" href="@yield('seo_canonical', url()->current())">

        <!-- Open Graph -->
        <meta property="og:type" content="@yield('og_type', 'website')">
        <meta property="og:site_name" content="Shalom Vasos Decor">
        <meta property="og:title" content="@yield('seo_title', 'Shalom Vasos Decor — Fábrica de Vasos de Concreto | Nova Esperança – PR')">
        <meta property="og:description" content="@yield('seo_description', 'Shalom Vasos Decor — fábrica de vasos de concreto e cimento em Nova Esperança, Paraná. Vasos artesanais para decoração, jardim e projetos especiais.')">
        <meta property="og:url" content="@yield('seo_canonical', url()->current())">
        <meta property="og:image" content="@yield('og_image', asset('images/icons/Logo_shalom.png'))">
        <meta property="og:locale" content="pt_BR">

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="@yield('seo_title', 'Shalom Vasos Decor')">
        <meta name="twitter:description" content="@yield('seo_description', 'Fábrica de vasos de concreto e cimento em Nova Esperança – PR.')">
        <meta name="twitter:image" content="@yield('og_image', asset('images/icons/Logo_shalom.png'))">

        <!-- Geo / Local Business -->
        <meta name="geo.region" content="BR-PR">
        <meta name="geo.placename" content="Nova Esperança, Paraná, Brasil">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        @stack('styles')

        <!-- JSON-LD: LocalBusiness (sempre presente) -->
        <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "LocalBusiness",
            "name": "Shalom Vasos Decor",
            "description": "Fábrica de vasos de concreto e cimento artesanais em Nova Esperança, Paraná. Produtos para decoração, jardim e projetos especiais.",
            "url": "{{ config('app.url') }}",
            "logo": "{{ asset('images/icons/Logo_shalom.png') }}",
            "image": "{{ asset('images/icons/Logo_shalom.png') }}",
            "telephone": "+55-44-99999-9999",
            "address": {
                "@@type": "PostalAddress",
                "streetAddress": "Rua Projetada Y, 5",
                "addressLocality": "Nova Esperança",
                "addressRegion": "PR",
                "addressCountry": "BR"
            },
            "geo": {
                "@@type": "GeoCoordinates",
                "latitude": "-23.186",
                "longitude": "-52.207"
            },
            "openingHours": "Mo-Fr 07:30-18:00",
            "priceRange": "$$",
            "sameAs": []
        }
        </script>
        @stack('structured_data')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-grow">
                @if(isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>

            <!-- Footer -->
            @include('layouts.footer')
        </div>
        
        @stack('scripts')
    </body>
</html>
