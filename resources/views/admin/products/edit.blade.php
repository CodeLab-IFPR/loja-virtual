@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Editar Produto: {{ $product->name }}</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.products.show', $product) }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                    Visualizar
                </a>
                <a href="{{ route('admin.products.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                    Voltar
                </a>
            </div>
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

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')
            
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
                               value="{{ old('name', $product->name) }}" 
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
                               value="{{ old('sku', $product->sku) }}" 
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
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                   {{ old('size_id', $product->size_id) == $size->id ? 'checked' : '' }}
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
                               value="{{ old('price', $product->price) }}" 
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
                               {{ old('manage_stock', $product->manage_stock) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <label for="manage_stock" class="ml-2 text-sm font-medium text-gray-700">
                            Gerenciar Estoque
                        </label>
                    </div>

                    <div id="stock_section" class="{{ old('manage_stock', $product->manage_stock) ? '' : 'hidden' }}">
                        <label for="stock" class="block text-sm font-medium text-gray-700">
                            Estoque Atual *
                        </label>
                        <input type="number" 
                               id="stock" 
                               name="stock" 
                               value="{{ old('stock', $product->stock) }}" 
                               min="0" 
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-sm text-gray-500">Quantidade disponível.</p>
                    </div>
                </div>
            </div>

            <!-- Informações Adicionais -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações Adicionais</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700">
                            Peso (kg)
                        </label>
                        <input type="number" 
                               id="weight" 
                               name="weight" 
                               value="{{ old('weight', $product->weight) }}" 
                               step="0.01" 
                               min="0"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="dimensions" class="block text-sm font-medium text-gray-700">
                            Dimensões (C x L x A)
                        </label>
                        <input type="text" 
                               id="dimensions" 
                               name="dimensions" 
                               value="{{ old('dimensions', $product->dimensions) }}" 
                               placeholder="Ex: 30x20x10 cm"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="material" class="block text-sm font-medium text-gray-700">
                            Material
                        </label>
                        <input type="text" 
                               id="material" 
                               name="material" 
                               value="{{ old('material', $product->material) }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700">
                            Cor
                        </label>
                        <input type="text" 
                               id="color" 
                               name="color" 
                               value="{{ old('color', $product->color) }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <!-- Descrição -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Descrição</h3>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Descreva o produto...">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Imagem Principal -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Imagem Principal</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <input type="file" 
                               id="image" 
                               name="image" 
                               accept="image/*"
                               class="mt-1 block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-indigo-50 file:text-indigo-700
                                      hover:file:bg-indigo-100">
                        <p class="mt-1 text-xs text-gray-500">JPG, PNG ou GIF até 2MB</p>
                    </div>

                    @if($product->image)
                        <div class="flex items-center space-x-4">
                            <img src="{{ Storage::url($product->image) }}" 
                                 alt="Imagem atual" 
                                 class="h-24 w-24 object-cover rounded-lg border">
                            <div>
                                <p class="text-sm text-gray-600">Imagem atual</p>
                                <a href="{{ route('admin.products.destroy-image', $product) }}" 
                                   class="text-red-600 hover:text-red-800 text-sm"
                                   onclick="return confirm('Remover imagem principal?')">
                                    Remover
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Imagens Adicionais -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Imagens Adicionais</h3>
                <input type="file" 
                       id="images" 
                       name="images[]" 
                       multiple 
                       accept="image/*"
                       class="mt-1 block w-full text-sm text-gray-500
                              file:mr-4 file:py-2 file:px-4
                              file:rounded-full file:border-0
                              file:text-sm file:font-semibold
                              file:bg-indigo-50 file:text-indigo-700
                              hover:file:bg-indigo-100">
                <p class="mt-1 text-xs text-gray-500">Adicione até 5 imagens (JPG, PNG, GIF)</p>

                @if($product->images && count($product->images) > 0)
                    <div class="mt-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($product->images as $index => $imagePath)
                            <div class="relative group">
                                <img src="{{ Storage::url($imagePath) }}" 
                                     alt="Imagem {{ $index + 1 }}" 
                                     class="h-32 w-full object-cover rounded-lg border">
                                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               name="remove_additional_images[]" 
                                               value="{{ $imagePath }}" 
                                               class="form-checkbox h-5 w-5 text-red-600">
                                        <span class="ml-2 text-white text-sm">Remover</span>
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Status e Destaque -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status e Destaque</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="active" 
                               name="active" 
                               {{ old('active', $product->active) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <label for="active" class="ml-2 text-sm font-medium text-gray-700">
                            Produto Ativo
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="featured" 
                               name="featured" 
                               {{ old('featured', $product->featured) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <label for="featured" class="ml-2 text-sm font-medium text-gray-700">
                            Destaque na Loja
                        </label>
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.products.index') }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700">
                    Atualizar Produto
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Controle do campo de estoque
    document.getElementById('manage_stock').addEventListener('change', function() {
        const stockSection = document.getElementById('stock_section');
        const stockInput = stockSection.querySelector('input');
        
        if (this.checked) {
            stockSection.classList.remove('hidden');
            stockInput.required = true;
        } else {
            stockSection.classList.add('hidden');
            stockInput.required = false;
        }
    });

    // Preview da imagem principal
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                let preview = document.getElementById('image-preview');
                if (!preview) {
                    preview = document.createElement('img');
                    preview.id = 'image-preview';
                    preview.className = 'mt-4 h-32 w-32 object-cover rounded-lg border';
                    document.querySelector('[for="image"]').parentNode.appendChild(preview);
                }
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection