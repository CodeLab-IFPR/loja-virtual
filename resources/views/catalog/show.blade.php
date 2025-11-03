@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-green-600">Início</a>
            <span class="mx-2">></span>
            <a href="{{ route('catalog') }}" class="hover:text-green-600">Catálogo</a>
            <span class="mx-2">></span>
            <a href="{{ route('catalog.category', $product->category->slug) }}" class="hover:text-green-600">{{ $product->category->name }}</a>
            <span class="mx-2">></span>
            <span class="text-gray-900">{{ $product->name }}</span>
        </nav>

        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-8">
                <!-- Product Image Gallery -->
                <div>
                    @php
                        $hasMainImage = $product->image;
                        $additionalImages = $product->images;
                        
                        // Se for string (JSON), decode
                        if (is_string($additionalImages)) {
                            $additionalImages = json_decode($additionalImages, true) ?: [];
                        } elseif (!is_array($additionalImages)) {
                            $additionalImages = [];
                        }
                        
                        $allImages = collect();
                        
                        if ($hasMainImage) {
                            $allImages->push([
                                'path' => $product->image,
                                'type' => 'main',
                                'label' => 'Principal'
                            ]);
                        }
                        
                        if (!empty($additionalImages)) {
                            foreach ($additionalImages as $index => $imagePath) {
                                $allImages->push([
                                    'path' => $imagePath,
                                    'type' => 'additional',
                                    'label' => 'Adicional ' . ($index + 1)
                                ]);
                            }
                        }
                    @endphp

                    @if($allImages->count() > 0)
                        <!-- Imagem Principal -->
                        <div class="mb-4">
                            <div class="aspect-square bg-gray-200 rounded-lg overflow-hidden relative group">
                                <img id="mainProductImage" 
                                     src="{{ asset('storage/' . $allImages->first()['path']) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover cursor-zoom-in"
                                     onclick="openImageModal('{{ asset('storage/' . $allImages->first()['path']) }}')">
                                
                                <!-- Indicador de zoom -->
                                <div class="absolute top-3 right-3 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Galeria de Miniaturas -->
                        @if($allImages->count() > 1)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">{{ $allImages->count() }} {{ $allImages->count() === 1 ? 'imagem' : 'imagens' }}</p>
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach($allImages as $index => $image)
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . $image['path']) }}" 
                                                 alt="{{ $image['label'] }}" 
                                                 onclick="changeMainProductImage('{{ asset('storage/' . $image['path']) }}', this)"
                                                 class="w-full h-20 object-cover rounded-lg border-2 {{ $index === 0 ? 'border-green-500' : 'border-gray-200' }} hover:border-green-400 cursor-pointer transition-all duration-200 hover:scale-105 thumbnail-image">
                                            @if($image['type'] === 'main')
                                                <span class="absolute top-1 left-1 bg-green-500 text-white text-xs px-1 rounded">Principal</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- Fallback quando não há imagens -->
                        <div class="aspect-square bg-gray-200 rounded-lg flex items-center justify-center">
                            <div class="text-center">
                                <div class="text-gray-400 mb-2" style="font-size: 8rem;">🏺</div>
                                <p class="text-gray-500 text-sm">Nenhuma imagem disponível</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full">{{ $product->category->name }}</span>
                        @if($product->featured)
                            <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">⭐ Destaque</span>
                        @endif
                    </div>

                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                    
                    <div class="text-gray-600 mb-6">
                        <p class="text-sm text-gray-500 mb-2">SKU: {{ $product->sku }}</p>
                        
                        @auth
                            @if(auth()->user()->canSeePrices())
                                <div class="text-4xl font-bold text-green-600 mb-4">R$ {{ number_format($product->price, 2, ',', '.') }}</div>
                            @else
                                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 mb-4">
                                    <p class="text-amber-800">⚠️ Sua conta está aguardando aprovação do administrador para visualizar preços.</p>
                                </div>
                            @endif
                        @else
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                <p class="text-blue-800">🔒 Faça login para visualizar preços e fazer pedidos.</p>
                                <div class="mt-3 space-x-3">
                                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">Fazer Login</a>
                                    <span class="text-gray-400">|</span>
                                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 font-medium">Cadastrar-se</a>
                                </div>
                            </div>
                        @endauth
                    </div>

                    <div class="mb-6">
                        <h3 class="font-semibold text-gray-900 mb-2">Descrição</h3>
                        <p class="text-gray-600">{{ $product->description }}</p>
                    </div>

                    @if($product->specifications)
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-2">Especificações</h3>
                            <p class="text-gray-600">{{ $product->specifications }}</p>
                        </div>
                    @endif

                    <div class="mb-6 flex space-x-16 items-center">
                        @if($product->material)
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1 ">Material</h3>
                                <p class="text-gray-600">{{ $product->material->name }}</p>
                            </div>
                        @endif
                        
                        @if($product->color)
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Cor</h3>
                                <p class="text-gray-600">{{ $product->color->name }}</p>
                            </div>
                        @endif

                        @if($product->dimensions)
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-0.5 ">Dimensões</h3>
                                <p class="text-gray-600">{{ $product->dimensions }}</p>
                            </div>
                        @endif

                        @if($product->size)
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Tamanho</h3>
                                <p class="text-gray-600">{{ $product->size->name }}</p>
                            </div>
                        @endif

                    </div>

                    <div class="mb-6">
                        <div class="flex items-center gap-4 text-sm">
                            @if($product->manage_stock)
                                <div class="flex items-center gap-2">
                                    @if($product->isInStock())
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                        <span class="text-green-600">Em estoque ({{ $product->stock }} unidades)</span>
                                    @else
                                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                        <span class="text-red-600">Fora de estoque</span>
                                    @endif
                                </div>
                            @else
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    <span class="text-green-600">Disponível</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    @auth
                        @if(auth()->user()->canSeePrices() && $product->isInStock())
                            <div class="space-y-3">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="flex items-center space-x-4 mb-4">
                                        <label for="quantity" class="font-medium text-gray-700">Quantidade:</label>
                                        <input type="number" name="quantity" id="quantity" value="1" min="1" 
                                               @if($product->manage_stock) max="{{ $product->stock }}" @endif
                                               class="border border-gray-300 rounded px-3 py-2 w-20">
                                    </div>
                                    <button type="submit" class="w-full bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition font-medium">
                                        Adicionar ao Carrinho
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Produtos Relacionados</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition">
                            <div class="h-48 bg-gray-200 flex items-center justify-center">
                                @if($relatedProduct->first_image)
                                    <img src="{{ $relatedProduct->first_image }}" alt="{{ $relatedProduct->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-gray-400 text-4xl">🏺</div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-2">{{ $relatedProduct->name }}</h3>
                                @auth
                                    @if(auth()->user()->canSeePrices())
                                        <p class="text-lg font-bold text-green-600 mb-3">R$ {{ number_format($relatedProduct->price, 2, ',', '.') }}</p>
                                    @endif
                                @endauth
                                <a href="{{ route('catalog.product', $relatedProduct->slug) }}" 
                                   class="block text-center bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition text-sm">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal de Zoom da Imagem -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-75 transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

<script>
    function changeMainProductImage(src, element) {
        // Mudar a imagem principal
        document.getElementById('mainProductImage').src = src;
        
        // Atualizar onclick do modal
        document.getElementById('mainProductImage').onclick = function() {
            openImageModal(src);
        };
        
        // Atualizar bordas das miniaturas
        document.querySelectorAll('.thumbnail-image').forEach(thumb => {
            thumb.classList.remove('border-green-500');
            thumb.classList.add('border-gray-200');
        });
        
        // Adicionar borda verde na miniatura clicada
        element.classList.remove('border-gray-200');
        element.classList.add('border-green-500');
    }

    function openImageModal(src) {
        document.getElementById('modalImage').src = src;
        document.getElementById('imageModal').classList.remove('hidden');
        document.getElementById('imageModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.getElementById('imageModal').classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    // Fechar modal ao clicar fora da imagem
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });

    // Fechar modal com tecla Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
</script>
@endsection