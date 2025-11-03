@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">{{ $material->name }}</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.materials.edit', $material) }}" 
                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                    Editar
                </a>
                <a href="{{ route('admin.materials.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                    Voltar
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informações do Material -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Detalhes Básicos -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações do Material</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nome</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $material->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Slug</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $material->slug }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <div class="mt-1">
                                @if($material->active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Ativo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Inativo
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total de Produtos</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $material->products->count() }} produtos</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Criado em</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $material->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Última atualização</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $material->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    
                    @if($material->description)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Descrição</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $material->description }}</p>
                    </div>
                    @endif
                </div>

                <!-- Produtos da Material -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Produtos ({{ $material->products->count() }})</h3>
                        <a href="{{ route('admin.products.create') }}?material={{ $material->id }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm">
                            Adicionar Produto
                        </a>
                    </div>
                    
                    @if($material->products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($material->products->take(6) as $product)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="w-full h-32 bg-gray-200 rounded-md mb-3 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    
                                    <h4 class="font-medium text-gray-900 truncate">{{ $product->name }}</h4>
                                    <p class="text-sm text-gray-500 mb-2">{{ $product->sku }}</p>
                                    
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-green-600">
                                            R$ {{ number_format($product->price, 2, ',', '.') }}
                                        </span>
                                        <a href="{{ route('admin.products.show', $product) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm">Ver</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($material->products->count() > 6)
                            <div class="mt-4 text-center">
                                <a href="{{ route('admin.products.index') }}?material={{ $material->id }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Ver todos os {{ $material->products->count() }} produtos →
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Nenhum produto</h3>
                            <p class="mt-1 text-sm text-gray-500">Este material ainda não possui produtos.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.products.create') }}?material={{ $material->id }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Adicionar primeiro produto
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Ações Rápidas -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ações</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.materials.edit', $material) }}" 
                           class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-center block transition">
                            Editar Material
                        </a>
                        
                        <button onclick="toggleStatus('{{ $material->slug }}')" 
                                class="w-full {{ $material->active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-2 rounded-md transition">
                            {{ $material->active ? 'Desativar' : 'Ativar' }} Material
                        </button>
                        
                        <a href="{{ route('catalog.material', $material->slug) }}" 
                           target="_blank"
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-center block transition">
                            Ver no Site
                        </a>

                        @if($material->products->count() === 0)
                            <form action="{{ route('admin.materials.destroy', $material) }}" 
                                    method="POST" 
                                    onsubmit="return confirm('Tem certeza que deseja excluir este material?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md transition">
                                    Excluir Material
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Estatísticas -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Estatísticas</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Total de produtos:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $material->products->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Produtos ativos:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $material->products->where('active', true)->count() }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Em estoque:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $material->products->where('stock', '>', 0)->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleStatus(materialSlug) {
        fetch(`/admin/materials/${materialSlug}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            location.reload();
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
</script>
@endsection