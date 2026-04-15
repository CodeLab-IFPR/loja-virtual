@extends('layouts.app')

@section('seo_title', 'Shalom Vasos Decor — Fábrica de Vasos de Concreto | Nova Esperança – PR')
@section('seo_description', 'Conheça a Shalom Vasos Decor, fábrica de vasos de concreto e cimento artesanais em Nova Esperança, Paraná. Produtos para decoração, jardim, paisagismo e projetos especiais. Atacado e varejo.')
@section('seo_keywords', 'vasos de concreto, vasos de cimento, fábrica de vasos Nova Esperança, vasos artesanais Paraná, decoração jardim, vasos atacado PR, Shalom Vasos Decor')
@section('seo_canonical', route('home'))

@section('content')
<div class="min-h-screen bg-gray-50">

    <!-- Hero compacto -->
    <div class="relative bg-[#062035] overflow-hidden">
        @if(!empty($slides) && $slides[0]['image'])
        <img src="{{ $slides[0]['image'] }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-30">
        @endif
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 md:py-20 flex flex-col items-center text-center">
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">Vasos de Concreto Artesanais<br class="hidden sm:block"> Direto da Fábrica</h1>
            <p class="text-gray-300 text-lg max-w-xl mb-6">Conheça nosso catálogo de vasos de concreto e cimento em Nova Esperança – PR. Ideal para decoração, jardim e paisagismo.</p>
            <a href="{{ route('catalog') }}"
               class="inline-block bg-green-600 text-white px-8 py-3 rounded-full font-semibold hover:bg-green-700 transition">
                Ver Catálogo Completo
            </a>
        </div>
    </div>

    <!-- Filtros rápidos por categoria -->
    @if($categories->count())
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 py-3 overflow-x-auto scrollbar-hide">
                <a href="{{ route('catalog') }}"
                   class="shrink-0 px-4 py-1.5 rounded-full text-sm font-medium bg-green-600 text-white hover:bg-green-700 transition">
                    Todos
                </a>
                @foreach($categories as $category)
                <a href="{{ route('catalog.category', $category->slug) }}"
                   class="shrink-0 px-4 py-1.5 rounded-full text-sm font-medium bg-gray-100 text-gray-700 hover:bg-green-50 hover:text-green-700 transition">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Produtos em Destaque -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
        <div class="flex items-end justify-between mb-8">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Produtos em Destaque</h2>
                <p class="text-gray-500 mt-1">Os mais populares da nossa loja</p>
            </div>
            <a href="{{ route('catalog') }}" class="hidden sm:inline-flex items-center gap-1 text-sm font-medium text-green-600 hover:text-green-700 transition">
                Ver todos
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-5">
            @forelse($featuredProducts as $product)
            <div class="group bg-white rounded-xl overflow-hidden border border-gray-100 hover:shadow-md hover:border-green-100 transition relative flex flex-col">

                <!-- Link que cobre o card inteiro (fica abaixo do favorito) -->
                <a href="{{ route('catalog.product', $product->slug) }}" class="absolute inset-0 z-0" aria-label="{{ $product->name }}"></a>

                <!-- Favorito -->
                <div class="absolute top-2 right-2 z-10">
                    <x-favorite-button :product="$product" />
                </div>

                <!-- Imagem -->
                <div class="h-36 sm:h-48 lg:h-52 bg-gray-100 overflow-hidden flex items-center justify-center pointer-events-none">
                    @if($product->first_image)
                    <img src="{{ $product->first_image }}" alt="{{ $product->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                         onerror="this.parentElement.innerHTML='<div class=\'w-full h-full flex flex-col items-center justify-center gap-1\'><svg class=\'w-8 h-8 text-gray-300\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'/></svg><span class=\'text-[10px] text-gray-400\'>Sem imagem</span></div>'">
                    @else
                    <div class="flex flex-col items-center justify-center gap-1">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-[10px] text-gray-400">Sem imagem</span>
                    </div>
                    @endif
                </div>

                <!-- Info -->
                <div class="p-3 sm:p-4 flex flex-col flex-1 pointer-events-none">
                    <span class="text-[10px] font-semibold text-green-600 uppercase tracking-wider">{{ $product->category->name }}</span>
                    <h3 class="mt-1 text-sm sm:text-base font-semibold text-gray-800 group-hover:text-green-700 transition line-clamp-2 leading-snug flex-1">{{ $product->name }}</h3>

                    <div class="mt-3 pt-2 border-t border-gray-100">
                        @auth
                            @if(auth()->user()->canSeePrices())
                            <span class="text-sm sm:text-lg font-bold text-gray-900">R$ {{ number_format($product->price, 2, ',', '.') }}</span>
                            @else
                            <span class="inline-flex items-center gap-1 text-xs font-medium text-amber-700 bg-amber-50 px-2 py-1 rounded-full">
                                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Aguardando aprovação
                            </span>
                            @endif
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-medium text-[#062035]/70 bg-slate-100 px-2 py-1 rounded-full">
                                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                Faça login para ver o preço
                            </span>
                        @endauth
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-16">
                <p class="text-gray-500 text-lg">Nenhum produto encontrado.</p>
            </div>
            @endforelse
        </div>

        <!-- Link mobile "ver todos" -->
        <div class="mt-6 text-center sm:hidden">
            <a href="{{ route('catalog') }}" class="text-sm font-medium text-green-600 hover:text-green-700">Ver todos os produtos &rarr;</a>
        </div>
    </div>

    <!-- Navegue por Categoria -->
    <div class="bg-white py-10 md:py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-8">Navegue por Categoria</h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($categories as $category)
                <a href="{{ route('catalog.category', $category->slug) }}" class="group relative rounded-xl bg-gray-50 border border-gray-100 p-5 text-center hover:border-green-200 hover:bg-green-50 transition">
                    <div class="text-3xl mb-2">🏺</div>
                    <h3 class="font-semibold text-gray-900 group-hover:text-green-700 text-sm">{{ $category->name }}</h3>
                    <p class="text-xs text-gray-400 mt-1">{{ $category->activeProductsCount() }} produtos</p>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Cores e Materiais -->
    @if($colors->count() || $materials->count())
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
        <div class="grid md:grid-cols-2 gap-8">
            @if($colors->count())
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4">Por Cor</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($colors as $color)
                    <a href="{{ route('catalog.color', $color->slug) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-gray-200 text-sm text-gray-700 hover:border-green-300 hover:text-green-700 transition">
                        @if($color->hex)
                        <span class="w-3 h-3 rounded-full border border-gray-300" style="background-color: {{ $color->hex }}"></span>
                        @endif
                        {{ $color->name }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            @if($materials->count())
            <div>
                <h3 class="text-lg font-bold text-gray-900 mb-4">Por Material</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($materials as $material)
                    <a href="{{ route('catalog.material', $material->slug) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-gray-200 text-sm text-gray-700 hover:border-green-300 hover:text-green-700 transition">
                        {{ $material->name }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- CTA -->
    <div class="bg-[#062035] text-white py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            @guest
            <h2 class="text-2xl md:text-3xl font-bold mb-3">Quer ver preços e fazer pedidos?</h2>
            <p class="text-gray-300 mb-6">Cadastre-se para ter acesso completo ao nosso catálogo</p>
            <a href="{{ route('register') }}"
               class="inline-block bg-white text-black px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
                Cadastrar-se Agora
            </a>
            @else
                @if(!auth()->user()->canSeePrices())
                <h2 class="text-2xl md:text-3xl font-bold mb-3">Conta em análise</h2>
                <p class="text-gray-300">Sua conta está aguardando aprovação do administrador.</p>
                @else
                <h2 class="text-2xl md:text-3xl font-bold mb-3">Explore todo o catálogo</h2>
                <p class="text-gray-300 mb-6">Veja todos os produtos disponíveis com preços e condições especiais</p>
                <a href="{{ route('catalog') }}"
                   class="inline-block bg-white text-black px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
                    Explorar Catálogo
                </a>
                @endif
            @endguest
        </div>
    </div>
</div>
@endsection