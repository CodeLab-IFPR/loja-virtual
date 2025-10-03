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
                                        {{ (old('category_id', $product->category_id) == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Descrição
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Preço e Estoque -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Preço e Estoque</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">
                            Preço (R$) *
                        </label>
                        <input type="number" 
                               id="price" 
                               name="price" 
                               value="{{ old('price', $product->price) }}" 
                               step="0.01" 
                               min="0" 
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700">
                            Estoque *
                        </label>
                        <input type="number" 
                               id="stock" 
                               name="stock" 
                               value="{{ old('stock', $product->stock) }}" 
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
                            Dimensões
                        </label>
                        <input type="text" 
                               id="dimensions" 
                               name="dimensions" 
                               value="{{ old('dimensions', $product->dimensions) }}" 
                               placeholder="Ex: 30x40x50 cm"
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
                               placeholder="Ex: Cerâmica, Plástico, etc."
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
                               placeholder="Ex: Branco, Terracota, etc."
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <!-- Imagens -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Imagens</h3>
                
                <!-- Imagens Atuais -->
                @php
                    $existingImages = $product->images ?: [];
                    $hasMainImage = $product->image;
                @endphp

                @if($hasMainImage || !empty($existingImages))
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Imagens Atuais</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @if($hasMainImage)
                                <div class="relative group" data-image-type="main">
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="Imagem principal" 
                                         class="h-24 w-24 object-cover rounded-lg border-2 border-blue-500">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all rounded-lg"></div>
                                    <span class="absolute top-1 left-1 bg-blue-500 text-white text-xs px-1 rounded">Principal</span>
                                    <button type="button" 
                                            onclick="removeExistingImage('main', '')" 
                                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                            @endif

                            @if(!empty($existingImages))
                                @foreach($existingImages as $index => $imagePath)
                                    <div class="relative group" data-image-type="additional" data-image-path="{{ $imagePath }}">
                                        <img src="{{ asset('storage/' . $imagePath) }}" 
                                             alt="Imagem adicional {{ $index + 1 }}" 
                                             class="h-24 w-24 object-cover rounded-lg border">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all rounded-lg"></div>
                                        <button type="button" 
                                                onclick="removeExistingImage('additional', '{{ $imagePath }}')" 
                                                class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Campos hidden para controlar remoção de imagens -->
                <input type="hidden" id="remove_main_image" name="remove_main_image" value="0">
                <div id="remove_additional_images"></div>

                <!-- Nova Imagem Principal -->
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ $hasMainImage ? 'Substituir Imagem Principal' : 'Nova Imagem Principal' }}
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                    <span>{{ $hasMainImage ? 'Selecionar nova imagem' : 'Selecionar imagem principal' }}</span>
                                    <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF até 2MB</p>
                        </div>
                    </div>
                    
                    <!-- Preview da Nova Imagem Principal -->
                    <div id="mainImagePreview" class="hidden mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preview da Nova Imagem:</label>
                        <div class="relative inline-block">
                            <img id="mainPreviewImg" src="" alt="Preview" class="h-32 w-48 object-cover rounded-lg border">
                            <button type="button" 
                                    onclick="removeMainImagePreview()" 
                                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Novas Imagens Adicionais -->
                <div>
                    <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                        Adicionar Mais Imagens (Opcional)
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                    <span>Selecionar múltiplas imagens</span>
                                    <input id="images" name="images[]" type="file" class="sr-only" accept="image/*" multiple>
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF até 2MB cada</p>
                        </div>
                    </div>
                    
                    <!-- Preview das Novas Imagens Adicionais -->
                    <div id="additionalImagesPreview" class="hidden mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Novas Imagens Adicionais:</label>
                        <div id="additionalImagesContainer" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="active" 
                               value="1" 
                               {{ old('active', $product->active) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Produto ativo</span>
                    </label>
                    <p class="mt-1 text-sm text-gray-500">Produtos inativos não aparecem no catálogo público.</p>
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
    let removedImages = [];

    // Preview da nova imagem principal
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('mainPreviewImg').src = e.target.result;
                document.getElementById('mainImagePreview').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    function removeMainImagePreview() {
        document.getElementById('image').value = '';
        document.getElementById('mainImagePreview').classList.add('hidden');
    }

    // Remover imagens existentes
    function removeExistingImage(type, path) {
        if (type === 'main') {
            document.getElementById('remove_main_image').value = '1';
            document.querySelector('[data-image-type="main"]').style.display = 'none';
        } else {
            // Adicionar ao array de imagens removidas
            removedImages.push(path);
            
            // Atualizar campo hidden
            updateRemovedImagesField();
            
            // Esconder elemento
            document.querySelector(`[data-image-path="${path}"]`).style.display = 'none';
        }
    }

    function updateRemovedImagesField() {
        const container = document.getElementById('remove_additional_images');
        container.innerHTML = '';
        
        removedImages.forEach(path => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'remove_additional_images[]';
            input.value = path;
            container.appendChild(input);
        });
    }

    // Preview das novas imagens adicionais
    document.getElementById('images').addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        const container = document.getElementById('additionalImagesContainer');
        const preview = document.getElementById('additionalImagesPreview');
        
        container.innerHTML = '';
        
        if (files.length > 0) {
            preview.classList.remove('hidden');
            
            files.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="Preview ${index + 1}" class="h-24 w-24 object-cover rounded-lg border">
                        <button type="button" onclick="removeNewAdditionalImage(${index})" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    `;
                    container.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        } else {
            preview.classList.add('hidden');
        }
    });

    function removeNewAdditionalImage(index) {
        // Recriar o campo de arquivo para remover a imagem específica
        const input = document.getElementById('images');
        const dt = new DataTransfer();
        const files = Array.from(input.files);
        
        files.forEach((file, i) => {
            if (i !== index) {
                dt.items.add(file);
            }
        });
        
        input.files = dt.files;
        input.dispatchEvent(new Event('change'));
    }
</script>
@endsection