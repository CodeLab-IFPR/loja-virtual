@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Meus Favoritos</h1>
                    <p class="text-gray-600 mt-2">Produtos que você marcou como favoritos</p>
                </div>
                <div class="text-sm text-gray-500">
                    {{ $favorites->total() }} {{ Str::plural('produto', $favorites->total()) }}
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($favorites->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($favorites as $product)
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
                            
                            @if(auth()->user()->canSeePrices())
                                <p class="text-xl font-bold text-green-600 mb-4">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                            @else
                                <p class="text-sm text-amber-600 mb-4">⚠️ Aguardando aprovação para ver preços</p>
                            @endif

                            <div class="flex justify-between items-center gap-2">
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
                {{ $favorites->links() }}
            </div>
        @else
            <div class="text-center py-16">
                <div class="text-6xl mb-4">💔</div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhum produto favorito ainda</h3>
                <p class="text-gray-600 mb-6">Comece a explorar nossos produtos e adicione seus favoritos clicando no ícone de coração!</p>
                <a href="{{ route('catalog') }}" 
                   class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                    Explorar Catálogo
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
