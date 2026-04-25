@extends('layouts.app')

@section('seo_title', $product->name . ' — Vaso de Concreto | Shalom Vasos Decor')
@section('seo_description', Str::limit(strip_tags($product->description ?? 'Vaso de concreto artesanal ' . $product->name . ' da Shalom Vasos Decor, fábrica em Nova Esperança – PR. Ideal para decoração, jardim e paisagismo.'), 155))
@section('seo_keywords', $product->name . ', vaso concreto, ' . ($product->category->name ?? '') . ', Shalom Vasos Decor, Nova Esperança Paraná')
@section('seo_canonical', route('catalog.product', $product->slug))
@section('og_type', 'product')
@section('og_image', $product->first_image ?? asset('images/icons/Logo_shalom.png'))

@push('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "Product",
    "name": "{{ $product->name }}",
    "description": "{{ Str::limit(strip_tags($product->description ?? ''), 200) }}",
    "image": "{{ $product->first_image ?? asset('images/icons/Logo_shalom.png') }}",
    "url": "{{ route('catalog.product', $product->slug) }}",
    "brand": {
        "@@type": "Brand",
        "name": "Shalom Vasos Decor"
    },
    "category": "{{ $product->category->name ?? 'Vasos de Concreto' }}",
    "manufacturer": {
        "@@type": "Organization",
        "name": "Shalom Vasos Decor",
        "address": {
            "@@type": "PostalAddress",
            "streetAddress": "Rua Projetada Y, 5",
            "addressLocality": "Nova Esperança",
            "addressRegion": "PR",
            "addressCountry": "BR"
        }
    },
    "offers": {
        "@@type": "Offer",
        "availability": "{{ $product->status === 'active' ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
        "priceCurrency": "BRL",
        "url": "{{ route('catalog.product', $product->slug) }}",
        "seller": {
            "@@type": "Organization",
            "name": "Shalom Vasos Decor"
        }
    }
}
</script>

<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "BreadcrumbList",
    "itemListElement": [
        { "@@type": "ListItem", "position": 1, "name": "Início", "item": "{{ route('home') }}" },
        { "@@type": "ListItem", "position": 2, "name": "Catálogo", "item": "{{ route('catalog') }}" },
        { "@@type": "ListItem", "position": 3, "name": "{{ $product->category->name ?? '' }}", "item": "{{ route('catalog.category', $product->category->slug) }}" },
        { "@@type": "ListItem", "position": 4, "name": "{{ $product->name }}", "item": "{{ route('catalog.product', $product->slug) }}" }
    ]
}
</script>
@endpush

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
                            <p class="text-gray-600 leading-relaxed">{!! nl2br(e($product->specifications)) !!}</p>
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

                    </div>

                    @if($product->sizes->count() > 0)
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-2">Tamanhos disponíveis</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->sizes as $size)
                                    <span class="inline-block bg-gray-100 text-gray-800 text-sm font-medium px-3 py-1 rounded-full border border-gray-300">
                                        {{ $size->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

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
                            <div class="space-y-3" x-data="{ selectedSize: null }">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="size_id" :value="selectedSize">

                                    @if($product->sizes->count() > 0)
                                        <div class="mb-4">
                                            <label class="block font-medium text-gray-700 mb-2">Selecione o tamanho: <span class="text-red-500">*</span></label>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($product->sizes as $size)
                                                    <button type="button"
                                                        @click="selectedSize = {{ $size->id }}"
                                                        :class="selectedSize === {{ $size->id }}
                                                            ? 'bg-green-600 text-white border-green-600'
                                                            : 'bg-white text-gray-800 border-gray-300 hover:border-green-500'"
                                                        class="px-4 py-2 rounded-lg border-2 font-medium text-sm transition-all duration-150">
                                                        {{ $size->name }}
                                                    </button>
                                                @endforeach
                                            </div>
                                            <p x-show="selectedSize === null" class="text-xs text-red-500 mt-1">Por favor, selecione um tamanho antes de adicionar ao carrinho.</p>
                                        </div>
                                    @endif

                                    <div class="flex items-center space-x-4 mb-4">
                                        <label for="quantity" class="font-medium text-gray-700">Quantidade:</label>
                                        <input type="number" name="quantity" id="quantity" value="1" min="1" 
                                               @if($product->manage_stock) max="{{ $product->stock }}" @endif
                                               class="border border-gray-300 rounded px-3 py-2 w-20">
                                    </div>
                                    <button type="submit"
                                        @if($product->sizes->count() > 0)
                                            :disabled="selectedSize === null"
                                            :class="selectedSize === null ? 'opacity-50 cursor-not-allowed' : 'hover:bg-green-700'"
                                        @endif
                                        class="w-full bg-green-600 text-white py-3 px-6 rounded-lg transition font-medium">
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
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 z-50 hidden items-center justify-center" role="dialog" aria-modal="true">

    <!-- Fechar ao clicar no fundo -->
    <div class="absolute inset-0" onclick="closeImageModal()"></div>

    <!-- Seta Anterior -->
    <button id="modalPrev" onclick="changeModalImage(-1)"
        class="absolute left-3 sm:left-6 z-10 text-white bg-black bg-opacity-50 hover:bg-opacity-80 rounded-full p-3 transition-all disabled:opacity-20 disabled:cursor-default">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>

    <!-- Imagem + Contador -->
    <div class="relative flex flex-col items-center max-w-[90vw] max-h-[90vh]" onclick="event.stopPropagation()">
        <img id="modalImage" src="" alt=""
            class="max-w-[90vw] max-h-[80vh] object-contain rounded-lg shadow-2xl select-none">
        <span id="modalCounter" class="mt-3 text-white text-sm opacity-70"></span>
    </div>

    <!-- Seta Próxima -->
    <button id="modalNext" onclick="changeModalImage(1)"
        class="absolute right-3 sm:right-6 z-10 text-white bg-black bg-opacity-50 hover:bg-opacity-80 rounded-full p-3 transition-all disabled:opacity-20 disabled:cursor-default">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    <!-- Fechar -->
    <button onclick="closeImageModal()"
        class="absolute top-4 right-4 z-10 text-white bg-black bg-opacity-50 hover:bg-opacity-80 rounded-full p-2 transition-all">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
</div>

@php
    $modalImageUrls = $allImages->map(fn($img) => asset('storage/' . $img['path']))->values();
@endphp

<script>
    const modalImages = @json($modalImageUrls);
    let modalIndex = 0;

    function openImageModal(src) {
        modalIndex = modalImages.indexOf(src);
        if (modalIndex === -1) modalIndex = 0;
        renderModal();
        document.getElementById('imageModal').classList.remove('hidden');
        document.getElementById('imageModal').classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function renderModal() {
        document.getElementById('modalImage').src = modalImages[modalIndex];
        document.getElementById('modalCounter').textContent = modalImages.length > 1
            ? (modalIndex + 1) + ' / ' + modalImages.length : '';
        document.getElementById('modalPrev').disabled = modalIndex === 0;
        document.getElementById('modalNext').disabled = modalIndex === modalImages.length - 1;
    }

    function changeModalImage(dir) {
        const next = modalIndex + dir;
        if (next >= 0 && next < modalImages.length) {
            modalIndex = next;
            renderModal();
        }
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.getElementById('imageModal').classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    function changeMainProductImage(src, element) {
        document.getElementById('mainProductImage').src = src;
        document.getElementById('mainProductImage').onclick = function() { openImageModal(src); };
        document.querySelectorAll('.thumbnail-image').forEach(t => {
            t.classList.remove('border-green-500');
            t.classList.add('border-gray-200');
        });
        element.classList.remove('border-gray-200');
        element.classList.add('border-green-500');
    }

    document.addEventListener('keydown', function(e) {
        if (!document.getElementById('imageModal').classList.contains('flex')) return;
        if (e.key === 'Escape')      closeImageModal();
        if (e.key === 'ArrowLeft')   changeModalImage(-1);
        if (e.key === 'ArrowRight')  changeModalImage(1);
    });
</script>
@endsection