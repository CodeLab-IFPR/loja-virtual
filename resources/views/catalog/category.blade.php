@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <nav class="text-sm text-gray-500 mb-4">
                <span class="mx-2">></span>
                <a href="{{ route('catalog') }}" class="hover:text-green-600">Catálogo</a>
                <span class="mx-2">></span>
                <span class="text-gray-900">{{ $category->name }}</span>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-gray-600 mt-2">{{ $category->description }}</p>
            @endif
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition relative">
                        <!-- Botão de favorito no canto superior direito -->
                        <div class="absolute top-2 right-2 z-10">
                            <x-favorite-button :product="$product" />
                        </div>
                        
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

                            <div class="flex justify-end">
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
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="text-6xl text-gray-400 mb-4">📦</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhum produto nesta categoria</h3>
                <p class="text-gray-600">Esta categoria ainda não possui produtos cadastrados.</p>
                <a href="{{ route('catalog') }}" class="inline-block mt-4 bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                    Ver Todos os Produtos
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
