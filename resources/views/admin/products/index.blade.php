@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Gerenciar Produtos</h1>
            <a href="{{ route('admin.products.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                Novo Produto
            </a>
        </div>

        <!-- Estatísticas -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-8">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-sm text-blue-600">Total</p>
                        <p class="text-2xl font-bold text-blue-700">{{ $stats['total'] }}</p>
                    </div>
                    <div class="text-blue-400">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2L3 7v11a2 2 0 002 2h10a2 2 0 002-2V7l-7-5z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-sm text-green-600">Ativos</p>
                        <p class="text-2xl font-bold text-green-700">{{ $stats['active'] }}</p>
                    </div>
                    <div class="text-green-400">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-sm text-red-600">Inativos</p>
                        <p class="text-2xl font-bold text-red-700">{{ $stats['inactive'] }}</p>
                    </div>
                    <div class="text-red-400">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-sm text-yellow-600">Em Estoque</p>
                        <p class="text-2xl font-bold text-yellow-700">{{ $stats['in_stock'] }}</p>
                    </div>
                    <div class="text-yellow-400">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-sm text-gray-600">Sem Estoque</p>
                        <p class="text-2xl font-bold text-gray-700">{{ $stats['out_of_stock'] }}</p>
                    </div>
                    <div class="text-gray-400">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros e Busca -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-64">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Nome, descrição ou SKU..."
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="min-w-48">
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                    <select id="category" 
                            name="category" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todas</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="min-w-32">
                    <label for="active" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="active" 
                            name="active" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todos</option>
                        <option value="1" {{ request('active') === '1' ? 'selected' : '' }}>Ativos</option>
                        <option value="0" {{ request('active') === '0' ? 'selected' : '' }}>Inativos</option>
                    </select>
                </div>
                <div class="min-w-32">
                    <label for="stock_status" class="block text-sm font-medium text-gray-700 mb-1">Estoque</label>
                    <select id="stock_status" 
                            name="stock_status" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todos</option>
                        <option value="in_stock" {{ request('stock_status') === 'in_stock' ? 'selected' : '' }}>Em Estoque</option>
                        <option value="low_stock" {{ request('stock_status') === 'low_stock' ? 'selected' : '' }}>Estoque Baixo</option>
                        <option value="out_of_stock" {{ request('stock_status') === 'out_of_stock' ? 'selected' : '' }}>Sem Estoque</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tabela de Produtos -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Produto
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Categoria
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Preço
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estoque
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16">
                                        @if($product->image)
                                            <img class="h-16 w-16 rounded-lg object-cover" 
                                                 src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}"
                                                 loading="lazy"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="h-16 w-16 rounded-lg bg-gray-300 items-center justify-center" style="display: none;">
                                                <svg class="h-8 w-8 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="h-16 w-16 rounded-lg bg-gray-300 flex items-center justify-center">
                                                <svg class="h-8 w-8 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-500">SKU: {{ $product->sku }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $product->category->name ?? 'Sem categoria' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                R$ {{ number_format($product->price, 2, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-900">{{ $product->stock }}</span>
                                    @if($product->stock == 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Sem estoque
                                        </span>
                                    @elseif($product->stock <= 10)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Estoque baixo
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Ativo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inativo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.products.show', $product) }}" 
                                       class="text-blue-600 hover:text-blue-900">Ver</a>
                                    
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                    
                                    <button onclick="toggleStatus({{ $product->id }})" 
                                            class="text-yellow-600 hover:text-yellow-900">
                                        {{ $product->active ? 'Desativar' : 'Ativar' }}
                                    </button>
                                    
                                    <button onclick="showStockModal({{ $product->id }}, {{ $product->stock }})" 
                                            class="text-green-600 hover:text-green-900">
                                        Estoque
                                    </button>
                                    
                                    <form action="{{ route('admin.products.destroy', $product) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Tem certeza que deseja excluir este produto?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Nenhum produto encontrado.
                                <a href="{{ route('admin.products.create') }}" 
                                   class="text-blue-600 hover:text-blue-800 ml-2">
                                    Criar primeiro produto
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        @if($products->hasPages())
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal de Gerenciar Estoque -->
<div id="stockModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900" id="stockModalTitle">Gerenciar Estoque</h3>
            <div class="mt-4">
                <form id="stockForm">
                    <input type="hidden" id="productId" value="">
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Estoque Atual:</label>
                        <span id="currentStock" class="text-lg font-bold text-blue-600"></span>
                    </div>
                    
                    <div class="mb-4">
                        <label for="stockAction" class="block text-sm font-medium text-gray-700 mb-1">Ação</label>
                        <select id="stockAction" class="w-full rounded-md border-gray-300 shadow-sm">
                            <option value="set">Definir quantidade</option>
                            <option value="add">Adicionar ao estoque</option>
                            <option value="subtract">Remover do estoque</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label for="stockQuantity" class="block text-sm font-medium text-gray-700 mb-1">Quantidade</label>
                        <input type="number" 
                               id="stockQuantity" 
                               min="0" 
                               class="w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    
                    <div class="flex justify-end space-x-2">
                        <button type="button" 
                                onclick="closeStockModal()" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            Atualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleStatus(productId) {
        fetch(`/admin/products/${productId}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro: ' + (data.message || 'Falha na operação'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erro na comunicação com o servidor');
        });
    }

    function showStockModal(productId, currentStock) {
        document.getElementById('productId').value = productId;
        document.getElementById('currentStock').textContent = currentStock;
        document.getElementById('stockQuantity').value = '';
        document.getElementById('stockModal').classList.remove('hidden');
    }

    function closeStockModal() {
        document.getElementById('stockModal').classList.add('hidden');
    }

    document.getElementById('stockForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const productId = document.getElementById('productId').value;
        const action = document.getElementById('stockAction').value;
        const quantity = document.getElementById('stockQuantity').value;
        
        fetch(`/admin/products/${productId}/update-stock`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                action: action,
                stock: parseInt(quantity)
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeStockModal();
                location.reload();
            } else {
                alert('Erro: ' + (data.message || 'Falha na operação'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erro na comunicação com o servidor');
        });
    });
</script>
@endsection