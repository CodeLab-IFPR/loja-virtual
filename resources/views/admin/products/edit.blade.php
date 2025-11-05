@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
        <div class="px-8 py-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Editar Produto</h1>
                    <p class="mt-2 text-sm text-gray-600">{{ $product->name }}</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.products.show', $product) }}"
                        class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg transition-colors duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Visualizar
                    </a>
                    <a href="{{ route('admin.products.index') }}"
                        class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-lg transition-colors duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Voltar
                    </a>
                </div>
            </div>
        </div>

        @if ($errors->any())
        <div class="mx-8 mt-6 p-4 bg-red-50 border-l-4 border-red-400 rounded-r-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Erros encontrados:</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data"
            class="px-8 py-8 space-y-8">
            @csrf
            @method('PUT')

            <!-- Informações Básicas + Descrição -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Informações Básicas
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nome do Produto <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $product->name) }}" 
                               required
                               placeholder="Ex: Camiseta Básica, Calça Jeans..."
                               class="px-4 py-3 mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">
                    </div>

                    <div>
                        <label for="sku" class="block text-sm font-semibold text-gray-700 mb-2">
                            SKU <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="sku" 
                               name="sku" 
                               value="{{ old('sku', $product->sku) }}" 
                               required
                               placeholder="Ex: CAM-001"
                               class="px-4 py-3 mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">
                        <p class="mt-2 text-xs text-gray-500">Código único de identificação do produto</p>
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Categoria <span class="text-red-500">*</span>
                        </label>
                        <select id="category_id" 
                                name="category_id" 
                                required
                                class="px-4 py-3 mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">
                            <option value="">Selecione uma categoria</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Descrição
                    </label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="5" 
                        class="px-4 py-3 mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 resize-none"
                        placeholder="Descreva os detalhes, características e benefícios do produto...">{{ old('description', $product->description) }}</textarea>
                    <p class="mt-2 text-xs text-gray-500">Descrição detalhada que será exibida na página do produto</p>
                </div>
            </div>

            <!-- Tamanho -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                    Tamanho
                </h3>
                <div class="space-y-3">
                    @forelse($sizes as $size)
                        <div class="bg-white p-3 rounded-lg border-2 border-gray-200 hover:border-indigo-300 transition-colors duration-200">
                            <label for="size_{{ $size->id }}" class="flex items-center cursor-pointer">
                                <input type="radio" 
                                       id="size_{{ $size->id }}" 
                                       name="size_id" 
                                       value="{{ $size->id }}"
                                       {{ old('size_id', $product->size_id) == $size->id ? 'checked' : '' }}
                                       class="w-5 h-5 text-indigo-600 border-gray-300 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">
                                <span class="ml-3 text-sm font-medium text-gray-900">
                                    {{ $size->name }}
                                    @if($size->description)
                                        <span class="text-gray-500 text-xs font-normal"> - {{ $size->description }}</span>
                                    @endif
                                </span>
                            </label>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 italic">Nenhum tamanho cadastrado.</p>
                    @endforelse
                </div>
            </div>

            <!-- Preço e Estoque -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Preço e Estoque
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-semibold text-gray-700 mb-2">
                            Preço <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">R$</span>
                            <input type="number" 
                                   id="price" 
                                   name="price" 
                                   value="{{ old('price', $product->price) }}" 
                                   step="0.01" 
                                   min="0" 
                                   required
                                   placeholder="0,00"
                                   class="pl-12 pr-4 py-3 mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Valor de venda do produto</p>
                    </div>

                    <!-- Gerenciar Estoque -->
                    <div class="bg-white p-4 rounded-lg border-2 border-gray-200">
                        <label class="flex items-start cursor-pointer group">
                            <input type="hidden" name="manage_stock" value="0">
                            <input type="checkbox" 
                                   id="manage_stock" 
                                   name="manage_stock" 
                                   value="1" 
                                   {{ old('manage_stock', $product->manage_stock) ? 'checked' : '' }}
                                   class="mt-1 w-5 h-5 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900 group-hover:text-indigo-600 transition-colors duration-200">
                                    Gerenciar Estoque
                                </span>
                                <p class="text-xs text-gray-500 mt-1">Controlar quantidade disponível</p>
                            </div>
                        </label>
                    </div>

                    <!-- Estoque (condicional) -->
                    <div id="stock_section" class="{{ old('manage_stock', $product->manage_stock) ? '' : 'hidden' }} md:col-span-2">
                        <label for="stock" class="block text-sm font-semibold text-gray-700 mb-2">
                            Estoque Atual <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="stock" 
                               name="stock" 
                               value="{{ old('stock', $product->stock) }}" 
                               min="0" 
                               required
                               placeholder="0"
                               class="px-4 py-3 mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">
                        <p class="mt-2 text-xs text-gray-500">Quantidade atual de produtos disponíveis</p>
                    </div>
                </div>
            </div>

            <!-- Especificações Técnicas -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Especificações Técnicas
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="weight" class="block text-sm font-semibold text-gray-700 mb-2">Peso (kg)</label>
                        <input type="number" id="weight" name="weight" value="{{ old('weight', $product->weight) }}" step="0.01" min="0"
                               placeholder="0.00"
                               class="px-4 py-3 mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">
                        <p class="mt-2 text-xs text-gray-500">Peso para cálculo de frete</p>
                    </div>
                    <div>
                        <label for="dimensions" class="block text-sm font-semibold text-gray-700 mb-2">Dimensões</label>
                        <input type="text" id="dimensions" name="dimensions" value="{{ old('dimensions', $product->dimensions) }}"
                               placeholder="Ex: 40x30x10 cm"
                               class="px-4 py-3 mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">
                        <p class="mt-2 text-xs text-gray-500">Formato: Largura x Altura x Profundidade</p>
                    </div>
                    <div>
                        <label for="material_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Material
                        </label>
                        <select id="material_id" 
                                name="material_id" 
                                class="px-4 py-3 mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">
                            <option value="">Selecione um material</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}" {{ old('material_id', $product->material_id) == $material->id ? 'selected' : '' }}>
                                    {{ $material->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="color_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Cor
                        </label>
                        <select id="color_id" 
                                name="color_id" 
                                class="px-4 py-3 mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">
                            <option value="">Selecione uma cor</option>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}" {{ old('color_id', $product->color_id) == $color->id ? 'selected' : '' }}>
                                    {{ $color->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Imagem Principal -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Imagem Principal
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <input type="file" id="image" name="image" accept="image/*"
                               class="mt-1 block w-full text-sm text-gray-600
                                      file:mr-4 file:py-3 file:px-6
                                      file:rounded-lg file:border-2 file:border-indigo-200
                                      file:text-sm file:font-semibold
                                      file:bg-indigo-50 file:text-indigo-700
                                      hover:file:bg-indigo-100 hover:file:border-indigo-300
                                      file:transition-all file:duration-200 cursor-pointer">
                        <p class="mt-3 text-xs text-gray-500">{{ $product->image ? 'Selecione para alterar' : 'Adicionar imagem principal' }}</p>
                    </div>
                    @if($product->image)
                        <div class="flex items-center space-x-4">
                            <img src="{{ Storage::url($product->image) }}" alt="Atual" class="h-32 w-32 object-cover rounded-lg border-2 border-gray-300 shadow-sm">
                            <a href="{{ route('admin.products.destroy-image', $product) }}" 
                               class="inline-flex items-center px-3 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors duration-200"
                               onclick="return confirm('Remover imagem principal?')">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Remover
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Imagens Adicionais -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Imagens Adicionais
                </h3>
                <input type="file" id="images" name="images[]" multiple accept="image/*"
                       class="mt-1 block w-full text-sm text-gray-600
                              file:mr-4 file:py-3 file:px-6
                              file:rounded-lg file:border-2 file:border-indigo-200
                              file:text-sm file:font-semibold
                              file:bg-indigo-50 file:text-indigo-700
                              hover:file:bg-indigo-100 hover:file:border-indigo-300
                              file:transition-all file:duration-200 cursor-pointer">
                <p class="mt-3 text-xs text-gray-500">Adicione mais imagens para a galeria do produto</p>

                @if($product->images && count($product->images) > 0)
                    <div class="mt-6">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Imagens atuais:</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($product->images as $index => $imagePath)
                                <div class="relative group">
                                    <img src="{{ Storage::url($imagePath) }}" alt="Imagem {{ $index + 1 }}" class="h-40 w-full object-cover rounded-lg border-2 border-gray-300 shadow-sm">
                                    <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                        <label class="flex items-center cursor-pointer px-3 py-2 bg-red-500 hover:bg-red-600 rounded-lg transition-colors duration-200">
                                            <input type="checkbox" name="remove_additional_images[]" value="{{ $imagePath }}" class="w-4 h-4 text-red-600 border-white rounded focus:ring-2 focus:ring-red-300">
                                            <span class="ml-2 text-white text-sm font-medium">Remover</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Status -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Status
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-4 rounded-lg border-2 border-gray-200">
                        <label class="flex items-start cursor-pointer group">
                            <input type="hidden" name="active" value="0">
                            <input type="checkbox" 
                                   id="active" 
                                   name="active" 
                                   value="1" 
                                   {{ old('active', $product->active) ? 'checked' : '' }}
                                   class="mt-1 w-5 h-5 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900 group-hover:text-indigo-600 transition-colors duration-200">
                                    Produto Ativo
                                </span>
                                <p class="text-xs text-gray-500 mt-1">Produto visível na loja</p>
                            </div>
                        </label>
                    </div>
                    <div class="bg-white p-4 rounded-lg border-2 border-gray-200">
                        <label class="flex items-start cursor-pointer group">
                            <input type="hidden" name="featured" value="0">
                            <input type="checkbox" 
                                   id="featured" 
                                   name="featured" 
                                   value="1" 
                                   {{ old('featured', $product->featured) ? 'checked' : '' }}
                                   class="mt-1 w-5 h-5 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-900 group-hover:text-indigo-600 transition-colors duration-200">
                                    Produto em Destaque
                                </span>
                                <p class="text-xs text-gray-500 mt-1">Aparece na página inicial</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Botões -->
            <div class="flex justify-end space-x-4 pt-8 mt-8 border-t-2 border-gray-200">
                <a href="{{ route('admin.products.index') }}"
                    class="inline-flex items-center bg-white py-3 px-6 border-2 border-gray-300 rounded-lg shadow-sm text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Cancelar
                </a>
                <button type="submit"
                    class="inline-flex items-center bg-indigo-600 border-2 border-indigo-600 rounded-lg shadow-md py-3 px-8 text-sm font-semibold text-white hover:bg-indigo-700 hover:border-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Atualizar Produto
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