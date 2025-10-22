@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-3xl font-bold text-gray-900">Catálogo de Produtos</h1>
            <p class="text-gray-600 mt-2">Explore nossa coleção completa de vasos artesanais</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h3 class="font-semibold text-gray-900 mb-4">Filtros</h3>
                    
                    <!-- Search -->
                    <form method="GET" action="{{ route('catalog') }}" class="mb-6">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Buscar produtos..." 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        @if(request('category_id'))
                            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        @endif
                        <button type="submit" class="w-full mt-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                            Buscar
                        </button>
                    </form>

                    <!-- Categories -->
                    <h4 class="font-medium text-gray-900 mb-3">Categorias</h4>
                    <div class="space-y-2">
                        <a href="{{ route('catalog') }}" 
                           class="block text-sm {{ !request('category_id') ? 'text-green-600 font-medium' : 'text-gray-600' }} hover:text-green-600">
                            Todas as categorias
                        </a>
                        @foreach($categories as $category)
                            <a href="{{ route('catalog', ['category_id' => $category->id]) }}" 
                               class="block text-sm {{ request('category_id') == $category->id ? 'text-green-600 font-medium' : 'text-gray-600' }} hover:text-green-600">
                                {{ $category->name }} ({{ $category->activeProductsCount() }})
                            </a>
                        @endforeach
                    </div></br>

                    @auth
                        @if(auth()->user()->canSeePrices())
                        <!-- Prices -->
                        <h4 class="font-medium text-gray-900 mb-3">Preços</h4>
                        <div class="space-y-2">
                            <a href="{{ route('catalog') }}" 
                            class="block text-sm {{ !request('price') ? 'text-green-600 font-medium' : 'text-gray-600' }} hover:text-green-600">
                                Todos os preços
                            </a>
                                <a href="{{ route('catalog', ['price' => 'Até R$ 100']) }}" 
                                class="block text-sm {{ request('price') == 'Até R$ 100' ? 'text-green-600 font-medium' : 'text-gray-600' }} hover:text-green-600">
                                    Até R$ 100
                                </a>
                                <a href="{{ route('catalog', ['price' => 'R$ 100 a R$ 200']) }}" 
                                class="block text-sm {{ request('price') == 'R$ 100 a R$ 200' ? 'text-green-600 font-medium' : 'text-gray-600' }} hover:text-green-600">
                                    R$ 100 a R$ 200
                                </a>
                                <a href="{{ route('catalog', ['price' => 'R$ 200 a R$ 300']) }}" 
                                class="block text-sm {{ request('price') == 'R$ 200 a R$ 300' ? 'text-green-600 font-medium' : 'text-gray-600' }} hover:text-green-600">
                                    R$ 200 a R$ 300
                                </a>
                        </div></br>
                        @endif
                    @endauth
                <!-- </div> -->
            <!-- </div> -->

            
            <!-- Colors -->
            <h4 class="font-medium text-gray-900 mb-3">Cores</h4>
            <div class="space-y-2">
                <a href="{{ route('catalog') }}" 
                    class="block text-sm {{ !request('color') ? 'text-green-600 font-medium' : 'text-gray-600' }} hover:text-green-600">
                    Todas as cores
                </a>
                @foreach($cores as $cor)
                    <a href="{{ route('catalog', ['color' => $cor]) }}" 
                        class="block text-sm {{ request('color') == $cor ? 'text-green-600 font-medium' : 'text-gray-600' }} hover:text-green-600">
                        {{ $cor }}
                    </a>
                @endforeach
            </div></br>

            <!-- Dimensions -->
            <h4 class="font-medium text-gray-900 mb-3">Dimensões</h4>
            <div class="space-y-2">
                <a href="{{ route('catalog') }}" 
                    class="block text-sm {{ !request('dimensions') ? 'text-green-600 font-medium' : 'text-gray-600' }} hover:text-green-600">
                    Todas as dimensões
                </a>
                @foreach($dimensoes as $dimensao)
                    <a href="{{ route('catalog', ['dimensions' => $dimensao]) }}" 
                        class="block text-sm {{ request('dimensions') == $dimensao ? 'text-green-600 font-medium' : 'text-gray-600' }} hover:text-green-600">
                        {{ $dimensao }}
                    </a>
                @endforeach
            </div></br>
            </div>
        </div>

            <!-- Products Grid -->
            <div class="lg:w-3/4">
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                                <div class="h-48 bg-gray-200 flex items-center justify-center">
                                    @if($product->first_image)
                                        <img src="{{ $product->first_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="text-gray-400 text-6xl">🏺</div>
                                    @endif
                                </div>
                                <div class="p-6">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($product->description, 100) }}</p>
                                    
                                    @auth
                                        @if(auth()->user()->canSeePrices())
                                            <p class="text-xl font-bold text-green-600 mb-4">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                                        @else
                                            <p class="text-sm text-amber-600 mb-4">⚠️ Aguardando aprovação para ver preços</p>
                                        @endif
                                    @else
                                        <p class="text-sm text-blue-600 mb-4">🔒 Faça login para ver preços</p>
                                    @endauth

                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $product->category->name }}</span>
                                        <a href="{{ route('catalog.product', $product->slug) }}" 
                                           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition text-sm">
                                            Ver Detalhes
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="text-6xl text-gray-400 mb-4">🔍</div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhum produto encontrado</h3>
                        <p class="text-gray-600">Tente ajustar os filtros ou fazer uma nova busca.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection