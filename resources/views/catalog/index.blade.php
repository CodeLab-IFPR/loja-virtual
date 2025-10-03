@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-green-600 to-green-800 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">Fábrica de Vasos</h1>
                <p class="text-xl md:text-2xl mb-8">Vasos artesanais de qualidade para seus jardins e plantas</p>
                <a href="{{ route('catalog') }}" class="inline-block bg-white text-green-800 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
                    Ver Catálogo Completo
                </a>
            </div>
        </div>
    </div>

    <!-- Featured Products -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Produtos em Destaque</h2>
            <p class="text-gray-600">Conheça alguns dos nossos vasos mais populares</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredProducts as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        @if($product->first_image)
                            <img src="{{ $product->first_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="text-gray-400 text-6xl">🏺</div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($product->description, 100) }}</p>
                        
                        @auth
                            @if(auth()->user()->canSeePrices())
                                <p class="text-2xl font-bold text-green-600 mb-4">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                            @else
                                <p class="text-sm text-amber-600 mb-4">⚠️ Aguardando aprovação para ver preços</p>
                            @endif
                        @else
                            <p class="text-sm text-blue-600 mb-4">🔒 Faça login para ver preços</p>
                        @endauth

                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">{{ $product->category->name }}</span>
                            <a href="{{ route('catalog.product', $product->slug) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                                Ver Detalhes
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-16">
                    <p class="text-gray-600 text-lg">Nenhum produto encontrado.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Categories -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Nossas Categorias</h2>
                <p class="text-gray-600">Explore nossa variedade de vasos por categoria</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                @foreach($categories as $category)
                    <a href="{{ route('catalog.category', $category->slug) }}" class="group">
                        <div class="bg-gray-50 rounded-lg p-6 text-center hover:bg-green-50 transition">
                            <div class="text-4xl mb-4">🏺</div>
                            <h3 class="font-semibold text-gray-900 group-hover:text-green-600">{{ $category->name }}</h3>
                            <p class="text-sm text-gray-500 mt-2">{{ $category->activeProductsCount() }} produtos</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-green-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Pronto para começar?</h2>
            <p class="text-xl mb-8">Cadastre-se para ter acesso completo aos nossos produtos e preços</p>
            @guest
                <a href="{{ route('register') }}" class="inline-block bg-white text-green-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
                    Cadastrar-se Agora
                </a>
            @else
                @if(!auth()->user()->isApprovedCustomer())
                    <p class="text-lg">Sua conta está aguardando aprovação do administrador.</p>
                @else
                    <a href="{{ route('catalog') }}" class="inline-block bg-white text-green-600 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
                        Explorar Catálogo
                    </a>
                @endif
            @endguest
        </div>
    </div>
</div>
@endsection