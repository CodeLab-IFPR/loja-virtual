@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Novo Produto</h1>
            <a href="{{ route('admin.products.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                Voltar
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            
            <!-- Informações Básicas -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações Básicas</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Nome do Produto *
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700">
                            SKU *
                        </label>
                        <input type="text" 
                               id="sku" 
                               name="sku" 
                               value="{{ old('sku') }}" 
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-sm text-gray-500">Código único do produto.</p>
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">
                            Categoria *
                        </label>
                        <select id="category_id" 
                                name="category_id" 
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecione uma categoria</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- TAMANHO (APENAS UM) -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tamanho</h3>
                <div class="space-y-3">
                    @forelse($sizes as $size)
                        <div class="flex items-center">
                            <input type="radio" 
                                id="size_{{ $size->id }}" 
                                name="size_id" 
                                value="{{ $size->id }}"
                                {{ old('size_id') == $size->id ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="size_{{ $size->id }}" class="ml-2 text-sm text-gray-700">
                                <strong>{{ $size->name }}</strong>
                                @if($size->description)
                                    <span class="text-gray-500 block text-xs">- {{ $size->description }}</span>
                                @endif
                            </label>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Nenhum tamanho cadastrado.</p>
                    @endforelse
                </div>
                @error('size_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Preço e Estoque -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Preço e Estoque</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">
                            Preço *
                        </label>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               value="{{ old('price') }}" 
                               step="0.01" 
                               min="0" 
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-sm text-gray-500">Preço em R$.</p>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="manage_stock" 
                               name="manage_stock" 
                               {{ old('manage_stock', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <label for="manage_stock" class="ml-2 text-sm font-medium text-gray-700">
                            Gerenciar Estoque
                        </label>
                    </div>

                    <div id="stock_section" class="{{ old('manage_stock', true) ? '' : 'hidden' }}">
                        <label for="stock" class="block text-sm font-medium text-gray-700">
                            Estoque Inicial *
                        </label>
                        <input type="number" 
                               id="stock" 
                               name="stock" 
                               value="{{ old('stock', 0) }}" 
                               min="0" 
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-sm text-gray-500">Quantidade disponível.</p>
                    </div>
                </div>
            </div>

            <!-- ... resto do formulário (descrição, especificações, imagens, etc.) ... -->
            <!-- (mantido exatamente como estava) -->

            <!-- Botões de Ação -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.products.index') }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700">
                    Criar Produto
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // ... scripts de preview de imagens (mantidos) ...
</script>
@endsection