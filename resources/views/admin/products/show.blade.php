@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <!-- Cabeçalho -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h1>
                <p class="text-sm text-gray-500 mt-1">SKU: {{ $product->sku }}</p>
            </div>
            <div class="flex space-x-2">
                <button onclick="toggleStatus({{ $product->id }}, {{ $product->active ? 'false' : 'true' }})" 
                        class="px-4 py-2 rounded-md text-sm font-medium transition-colors {{ $product->active ? 'bg-yellow-500 hover:bg-yellow-600 text-white' : 'bg-green-500 hover:bg-green-600 text-white' }}">
                    {{ $product->active ? 'Desativar' : 'Ativar' }}
                </button>
                <a href="{{ route('admin.products.edit', $product) }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                    Editar
                </a>
                <a href="{{ route('admin.products.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                    Voltar
                </a>
            </div>
        </div>

        <!-- Status Badge -->
        <div class="mb-6">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $product->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ $product->active ? 'Ativo' : 'Inativo' }}
            </span>
            @if($product->stock <= 0)
                <span class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                    Sem Estoque
                </span>
            @elseif($product->stock <= 5)
                <span class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                    Estoque Baixo
                </span>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Coluna Principal - Imagens e Informações -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Galeria de Imagens -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Imagens</h3>
                    
                    @php
                        $allImages = $product->all_images;
                    @endphp

                    @if(count($allImages) > 0)
                        <!-- Imagem Principal -->
                        <div class="mb-6">
                            <img id="mainDisplayImage" 
                                 src="{{ $allImages[0]['url'] }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-96 object-cover rounded-lg border"
                                 loading="lazy">
                        </div>

                        <!-- Galeria de Miniaturas -->
                        @if(count($allImages) > 1)
                            <div class="grid grid-cols-4 md:grid-cols-6 gap-2">
                                @foreach($allImages as $index => $image)
                                    <div class="relative">
                                        <img src="{{ $image['url'] }}" 
                                             alt="{{ $image['label'] }}" 
                                             onclick="changeMainImage('{{ $image['url'] }}')"
                                             class="h-20 w-20 object-cover rounded-lg border-2 border-gray-200 hover:border-blue-500 cursor-pointer transition-colors"
                                             loading="lazy">
                                        @if($image['type'] === 'main')
                                            <span class="absolute top-1 left-1 bg-blue-500 text-white text-xs px-1 rounded">Principal</span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @else
                        <div class="flex items-center justify-center h-64 bg-gray-100 rounded-lg">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Sem imagens</h3>
                                <p class="mt-1 text-sm text-gray-500">Nenhuma imagem foi adicionada a este produto.</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Informações Detalhadas -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações Detalhadas</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Categoria</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->category->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Preço</label>
                            <p class="mt-1 text-lg font-semibold text-green-600">R$ {{ number_format($product->price, 2, ',', '.') }}</p>
                        </div>

                        @if($product->weight)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Peso</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $product->weight }} kg</p>
                            </div>
                        @endif

                        @if($product->dimensions)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dimensões</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $product->dimensions }}</p>
                            </div>
                        @endif

                        @if($product->material)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Material</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $product->material }}</p>
                            </div>
                        @endif

                        @if($product->color)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Cor</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $product->color }}</p>
                            </div>
                        @endif
                    </div>

                    @if($product->description)
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                            <div class="prose prose-sm max-w-none">
                                <p class="text-gray-900 whitespace-pre-line">{{ $product->description }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar - Ações e Estatísticas -->
            <div class="space-y-6">
                <!-- Gerenciamento de Estoque -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Estoque</h3>
                    
                    <div class="text-center mb-4">
                        <div class="text-3xl font-bold {{ $product->stock <= 0 ? 'text-red-600' : ($product->stock <= 5 ? 'text-yellow-600' : 'text-green-600') }}">
                            {{ $product->stock }}
                        </div>
                        <div class="text-sm text-gray-500">unidades</div>
                    </div>

                    <button onclick="openStockModal()" 
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition-colors">
                        Gerenciar Estoque
                    </button>
                </div>

                <!-- Ações Rápidas -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ações</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.products.edit', $product) }}" 
                           class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md inline-block text-center transition-colors">
                            Editar Produto
                        </a>
                        
                        <button onclick="toggleStatus({{ $product->id }}, {{ $product->active ? 'false' : 'true' }})" 
                                class="w-full px-4 py-2 rounded-md transition-colors {{ $product->active ? 'bg-yellow-500 hover:bg-yellow-600 text-white' : 'bg-green-500 hover:bg-green-600 text-white' }}">
                            {{ $product->active ? 'Desativar' : 'Ativar' }}
                        </button>
                        
                        <button onclick="confirmDelete()" 
                                class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition-colors">
                            Excluir Produto
                        </button>
                    </div>
                </div>

                <!-- Informações de Sistema -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div>
                            <span class="text-gray-500">Criado em:</span>
                            <div class="font-medium">{{ $product->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        
                        <div>
                            <span class="text-gray-500">Atualizado em:</span>
                            <div class="font-medium">{{ $product->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                        
                        <div>
                            <span class="text-gray-500">ID:</span>
                            <div class="font-medium">#{{ $product->id }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Gerenciamento de Estoque -->
<div id="stockModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Gerenciar Estoque</h3>
            
            <div class="mb-4">
                <p class="text-sm text-gray-600">Estoque atual: <span class="font-semibold">{{ $product->stock }} unidades</span></p>
            </div>

            <div class="space-y-4">
                <div>
                    <label for="stockOperation" class="block text-sm font-medium text-gray-700">Operação</label>
                    <select id="stockOperation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="add">Adicionar</option>
                        <option value="subtract">Subtrair</option>
                        <option value="set">Definir</option>
                    </select>
                </div>

                <div>
                    <label for="stockAmount" class="block text-sm font-medium text-gray-700">Quantidade</label>
                    <input type="number" 
                           id="stockAmount" 
                           min="0" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                           placeholder="Digite a quantidade">
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <button onclick="closeStockModal()" 
                        class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancelar
                </button>
                <button onclick="updateStock()" 
                        class="bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-700">
                    Atualizar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Confirmar Exclusão</h3>
            <p class="text-sm text-gray-600 mb-6">
                Tem certeza que deseja excluir o produto "{{ $product->name }}"? 
                Esta ação não pode ser desfeita.
            </p>
            
            <div class="flex justify-end space-x-3">
                <button onclick="closeDeleteModal()" 
                        class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancelar
                </button>
                <form id="deleteForm" action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-red-700">
                        Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function changeMainImage(src) {
        document.getElementById('mainDisplayImage').src = src;
    }

    function openStockModal() {
        document.getElementById('stockModal').classList.remove('hidden');
    }

    function closeStockModal() {
        document.getElementById('stockModal').classList.add('hidden');
        document.getElementById('stockAmount').value = '';
    }

    function updateStock() {
        const operation = document.getElementById('stockOperation').value;
        const amount = document.getElementById('stockAmount').value;
        
        if (!amount || amount < 0) {
            alert('Por favor, insira uma quantidade válida.');
            return;
        }

        fetch(`{{ route('admin.products.update-stock', $product) }}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                operation: operation,
                amount: parseInt(amount)
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Erro ao atualizar estoque.');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao atualizar estoque.');
        });
    }

    function toggleStatus(productId, newStatus) {
        fetch(`{{ route('admin.products.toggle-status', $product) }}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                active: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Erro ao alterar status.');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao alterar status.');
        });
    }

    function confirmDelete() {
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection