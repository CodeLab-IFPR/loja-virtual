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
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold text-gray-900">Filtrar por</h3>
                        <button onclick="clearAllFilters()" class="text-sm text-gray-500 hover:text-red-500">
                            Limpar filtros
                        </button>
                    </div>

                    <form id="filterForm" method="GET" action="{{ route('catalog') }}"
                        class=" overflow-y-auto pr-3  -mr-4">
                        <!-- Search -->
                        <div class="mb-6">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Buscar produtos..."
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                        </div>

                        <!-- Categories -->
                        <div class="mb-4">
                            <h4 class="font-medium text-gray-900 mb-1">Categoria</h4>
                            <div>
                                @foreach($categories as $category)
                                <label class="flex items-center text-sm cursor-pointer hover:bg-gray-50 p-1 rounded">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                        {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}
                                        class="mr-2 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                                        onchange="applyFilters()">
                                    <span class="text-gray-700">{{ $category->name }}</span>
                                    <span
                                        class="ml-auto text-xs text-gray-400">({{ $category->activeProductsCount() }})</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        @auth
                        @if(auth()->user()->canSeePrices())
                        <!-- Prices -->
                        <div class="mb-4">
                            <h4 class="font-medium text-gray-900 mb-1">Preço</h4>
                            <div>
                                <label class="flex items-center text-sm cursor-pointer hover:bg-gray-50 p-1 rounded">
                                    <input type="checkbox" name="price_ranges[]" value="0-100"
                                        {{ in_array('0-100', request('price_ranges', [])) ? 'checked' : '' }}
                                        class="mr-2 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                                        onchange="applyFilters()">
                                    <span class="text-gray-700">Até R$ 100</span>
                                </label>
                                <label class="flex items-center text-sm cursor-pointer hover:bg-gray-50 p-1 rounded">
                                    <input type="checkbox" name="price_ranges[]" value="100-200"
                                        {{ in_array('100-200', request('price_ranges', [])) ? 'checked' : '' }}
                                        class="mr-2 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                                        onchange="applyFilters()">
                                    <span class="text-gray-700">R$ 100 a R$ 200</span>
                                </label>
                                <label class="flex items-center text-sm cursor-pointer hover:bg-gray-50 p-1 rounded">
                                    <input type="checkbox" name="price_ranges[]" value="200-300"
                                        {{ in_array('200-300', request('price_ranges', [])) ? 'checked' : '' }}
                                        class="mr-2 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                                        onchange="applyFilters()">
                                    <span class="text-gray-700">R$ 200 a R$ 300</span>
                                </label>
                            </div>
                        </div>
                        @endif
                        @endauth

                        <!-- Materials -->
                        <div class="mb-4">
                            <h4 class="font-medium text-gray-900 mb-1">Materiais</h4>
                            <div>
                                @foreach($materials as $material)
                                <label class="flex items-center text-sm cursor-pointer hover:bg-gray-50 p-1 rounded">
                                    <input type="checkbox" name="materials[]" value="{{ $material->id }}"
                                        {{ in_array($material->id, request('materials', [])) ? 'checked' : '' }}
                                        class="mr-2 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                                        onchange="applyFilters()">
                                    <span class="text-gray-700">{{ $material->name }}</span>
                                    <span
                                        class="ml-auto text-xs text-gray-400">({{ $material->activeProductsCount() }})</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Colors -->
                        <div class="mb-4">
                            <h4 class="font-medium text-gray-900 mb-1">Cor</h4>
                            <div>
                                @foreach($colors as $color)
                                <label class="flex items-center text-sm cursor-pointer hover:bg-gray-50 p-1 rounded">
                                    <input type="checkbox" name="colors[]" value="{{ $color->id }}"
                                        {{ in_array($color->id, request('colors', [])) ? 'checked' : '' }}
                                        class="mr-2 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                                        onchange="applyFilters()">
                                    <span class="text-gray-700">{{ $color->name }}</span>
                                    <span
                                        class="ml-auto text-xs text-gray-400">({{ $color->activeProductsCount() }})</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Dimensions -->
                        <div class="mb-4">
                            <h4 class="font-medium text-gray-900 mb-1">Dimensões</h4>
                            <div>
                                @foreach($dimensoes as $dimensao)
                                <label class="flex items-center text-sm cursor-pointer hover:bg-gray-50 p-1 rounded">
                                    <input type="checkbox" name="dimensions[]" value="{{ $dimensao }}"
                                        {{ in_array($dimensao, request('dimensions', [])) ? 'checked' : '' }}
                                        class="mr-2 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                                        onchange="applyFilters()">
                                    <span class="text-gray-700">{{ $dimensao }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Apply Filters Button -->
                        <button type="submit"
                            class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                            Aplicar Filtros
                        </button>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:w-3/4">
                <!-- Active Filters Display -->
                @php
                $hasActiveFilters = request('search') ||
                request('categories') ||
                request('price_ranges') ||
                request('colors') ||
                request('dimensions');
                @endphp

                @if($hasActiveFilters)
                <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-sm font-medium text-gray-700">Filtros ativos:</span>

                        @if(request('search'))
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Busca: "{{ request('search') }}"
                            <button onclick="clearFilter('search')"
                                class="ml-1 text-green-600 hover:text-green-800">×</button>
                        </span>
                        @endif

                        @if(request('categories'))
                        @foreach($categories->whereIn('id', request('categories')) as $category)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $category->name }}
                            <button onclick="clearCategoryFilter({{ $category->id }})"
                                class="ml-1 text-blue-600 hover:text-blue-800">×</button>
                        </span>
                        @endforeach
                        @endif

                        @if(request('price_ranges'))
                        @foreach(request('price_ranges') as $range)
                        @php
                        $priceLabels = [
                        '0-100' => 'Até R$ 100',
                        '100-200' => 'R$ 100 a R$ 200',
                        '200-300' => 'R$ 200 a R$ 300'
                        ];
                        @endphp
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            {{ $priceLabels[$range] ?? $range }}
                            <button onclick="clearPriceFilter('{{ $range }}')"
                                class="ml-1 text-yellow-600 hover:text-yellow-800">×</button>
                        </span>
                        @endforeach
                        @endif

                        @if(request('colors'))
                        @foreach($colors->whereIn('id', request('colors')) as $color)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            {{ $color->name }}
                            <button onclick="clearColorFilter({{ $color->id }})"
                                class="ml-1 text-purple-600 hover:text-purple-800">×</button>
                        </span>
                        @endforeach
                        @endif

                        @if(request('dimensions'))
                        @foreach(request('dimensions') as $dimension)
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            {{ $dimension }}
                            <button onclick="clearDimensionFilter('{{ $dimension }}')"
                                class="ml-1 text-gray-600 hover:text-gray-800">×</button>
                        </span>
                        @endforeach
                        @endif

                        <button onclick="clearAllFilters()" class="text-sm text-red-600 hover:text-red-800 underline">
                            Limpar todos
                        </button>
                    </div>
                </div>
                @endif

                <!-- Results count -->
                <div class="flex justify-between items-center mb-6">
                    <p class="text-sm text-gray-600">
                        Exibindo {{ $products->count() }} de {{ $products->total() }} produtos
                    </p>
                </div>

                @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition relative">
                        <!-- Botão de favorito no canto superior direito -->
                        <div class="absolute top-2 right-2 z-10">
                            <x-favorite-button :product="$product" />
                        </div>

                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                            @if($product->first_image)
                            <img src="{{ $product->first_image }}" alt="{{ $product->name }}"
                                class="w-full h-full object-cover">
                            @else
                            <div class="text-gray-400 text-6xl">🏺</div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4">{{ Str::limit($product->description, 100) }}</p>

                            @auth
                            @if(auth()->user()->canSeePrices())
                            <p class="text-xl font-bold text-green-600 mb-4">R$
                                {{ number_format($product->price, 2, ',', '.') }}</p>
                            @else
                            <p class="text-sm text-amber-600 mb-4">⚠️ Aguardando aprovação para ver preços</p>
                            @endif
                            @else
                            <p class="text-sm text-blue-600 mb-4">🔒 Faça login para ver preços</p>
                            @endauth

                            <div class="flex justify-between items-center">
                                <!-- <span
                                    class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded w-36">{{ $product->category->name }}</span> -->
                                <a href="{{ route('catalog.product', $product->slug) }}"
                                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition text-sm w-36 text-center">
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

<script>
function applyFilters() {
    // Mostrar loading
    showLoading();

    // Auto-submit form quando um filtro é alterado
    setTimeout(() => {
        document.getElementById('filterForm').submit();
    }, 100);
}

function showLoading() {
    // Adicionar classe de loading ao botão de aplicar filtros
    const button = document.querySelector('#filterForm button[type="submit"]');
    if (button) {
        button.textContent = 'Aplicando...';
        button.disabled = true;
    }
}

function clearAllFilters() {
    showLoading();

    // Limpar todos os checkboxes
    const checkboxes = document.querySelectorAll('#filterForm input[type="checkbox"]');
    checkboxes.forEach(checkbox => checkbox.checked = false);

    // Limpar campo de busca
    document.querySelector('input[name="search"]').value = '';

    // Submeter form limpo
    document.getElementById('filterForm').submit();
}

function clearFilter(filterName) {
    if (filterName === 'search') {
        document.querySelector('input[name="search"]').value = '';
    }
    document.getElementById('filterForm').submit();
}

function clearCategoryFilter(categoryId) {
    const checkbox = document.querySelector(`input[name="categories[]"][value="${categoryId}"]`);
    if (checkbox) {
        checkbox.checked = false;
        document.getElementById('filterForm').submit();
    }
}

function clearColorFilter(colorId) {
    const checkbox = document.querySelector(`input[name="colors[]"][value="${colorId}"]`);
    if (checkbox) {
        checkbox.checked = false;
        document.getElementById('filterForm').submit();
    }
}

function clearMaterialFilter(materialId) {
    const checkbox = document.querySelector(`input[name="materials[]"][value="${materialId}"]`);
    if (checkbox) {
        checkbox.checked = false;
        document.getElementById('filterForm').submit();
    }
}

function clearPriceFilter(range) {
    const checkbox = document.querySelector(`input[name="price_ranges[]"][value="${range}"]`);
    if (checkbox) {
        checkbox.checked = false;
        document.getElementById('filterForm').submit();
    }
}

function clearDimensionFilter(dimension) {
    const checkbox = document.querySelector(`input[name="dimensions[]"][value="${dimension}"]`);
    if (checkbox) {
        checkbox.checked = false;
        document.getElementById('filterForm').submit();
    }
}

// Aplicar filtros automaticamente quando busca é alterada
document.querySelector('input[name="search"]').addEventListener('input', function() {
    clearTimeout(this.searchTimeout);
    this.searchTimeout = setTimeout(() => {
        applyFilters();
    }, 500);
});
</script>
@endsection