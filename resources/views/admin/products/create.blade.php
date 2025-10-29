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

            <!-- Informações Básicas + Descrição -->
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
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">
                            Categoria *
                        </label>
                        <select id="category_id" 
                                name="category_id" 
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecione</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700">
                        Descrição
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="4" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Descreva o produto...">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Tamanho -->
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
                                {{ $size->name }}
                                @if($size->description)
                                    <span class="text-gray-500 text-xs"> - {{ $size->description }}</span>
                                @endif
                            </label>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Nenhum tamanho cadastrado.</p>
                    @endforelse
                </div>
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
                    </div>

                    <!-- Gerenciar Estoque -->
                    <div class="flex items-center">
                        <input type="hidden" name="manage_stock" value="0">
                        <input type="checkbox" 
                               id="manage_stock" 
                               name="manage_stock" 
                               value="1" 
                               {{ old('manage_stock', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <label for="manage_stock" class="ml-2 text-sm font-medium text-gray-700">
                            Gerenciar Estoque
                        </label>
                    </div>

                    <!-- Estoque (condicional) -->
                    <div id="stock_section" class="{{ old('manage_stock', true) ? '' : 'hidden' }} md:col-span-2">
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
                    </div>
                </div>
            </div>

            <!-- Especificações Técnicas -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Especificações Técnicas</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700">Peso (kg)</label>
                        <input type="number" id="weight" name="weight" value="{{ old('weight') }}" step="0.01" min="0"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="dimensions" class="block text-sm font-medium text-gray-700">Dimensões</label>
                        <input type="text" id="dimensions" name="dimensions" value="{{ old('dimensions') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="material" class="block text-sm font-medium text-gray-700">Material</label>
                        <input type="text" id="material" name="material" value="{{ old('material') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700">Cor</label>
                        <input type="text" id="color" name="color" value="{{ old('color') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <!-- Imagem Principal -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Imagem Principal</h3>
                <input type="file" id="image" name="image" accept="image/*"
                       class="mt-1 block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0
                              file:text-sm file:font-semibold
                              file:bg-indigo-50 file:text-indigo-700
                              hover:file:bg-indigo-100">
            </div>

            <!-- Imagens Adicionais -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Imagens Adicionais</h3>
                <input type="file" id="images" name="images[]" multiple accept="image/*"
                       class="mt-1 block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0
                              file:text-sm file:font-semibold
                              file:bg-indigo-50 file:text-indigo-700
                              hover:file:bg-indigo-100">
            </div>

            <!-- Status -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
                <div class="flex items-center space-x-6">
                    <div class="flex items-center">
                        <input type="hidden" name="active" value="0">
                        <input type="checkbox" 
                               id="active" 
                               name="active" 
                               value="1" 
                               {{ old('active', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <label for="active" class="ml-2 text-sm font-medium text-gray-700">Ativo</label>
                    </div>
                    <div class="flex items-center">
                        <input type="hidden" name="featured" value="0">
                        <input type="checkbox" 
                               id="featured" 
                               name="featured" 
                               value="1" 
                               {{ old('featured') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <label for="featured" class="ml-2 text-sm font-medium text-gray-700">Destaque</label>
                    </div>
                </div>
            </div>

            <!-- Botões -->
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
    document.getElementById('manage_stock').addEventListener('change', function() {
        const stockSection = document.getElementById('stock_section');
        const input = stockSection.querySelector('input');
        if (this.checked) {
            stockSection.classList.remove('hidden');
            input.required = true;
        } else {
            stockSection.classList.add('hidden');
            input.required = false;
        }
    });
</script>
@endsection