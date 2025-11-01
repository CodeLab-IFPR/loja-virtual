@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Editar Tamanho</h1>
            <div class="flex space-x-2">
                <a href="{{ route('admin.sizes.show', $size) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                    Ver Tamanho
                </a>
                <a href="{{ route('admin.sizes.index') }}" 
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

        <form action="{{ route('admin.sizes.update', $size) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6">
                <!-- Informações Básicas -->
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Nome do Tamanho *
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $size->name) }}" 
                               required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-sm text-gray-500">Slug atual: <code>{{ $size->slug }}</code></p>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Descrição
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $size->description) }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Descrição opcional do tamanho.</p>
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700">
                            Ordem de Classificação
                        </label>
                        <input type="number" 
                               id="sort_order" 
                               name="sort_order" 
                               value="{{ old('sort_order', $size->sort_order) }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-sm text-gray-500">Número para ordenação (maior número aparece primeiro).</p>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="active" 
                                   value="1" 
                                   {{ old('active', $size->active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-700">Tamanho ativo</span>
                        </label>
                        <p class="mt-1 text-sm text-gray-500">Tamanhos inativos não aparecem no catálogo público.</p>
                    </div>

                    <!-- Informações Adicionais -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-sm font-medium text-gray-900 mb-2">Informações</h3>
                        <div class="space-y-1 text-sm text-gray-600">
                            <p><strong>Criado em:</strong> {{ $size->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Última atualização:</strong> {{ $size->updated_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Produtos:</strong> {{ $size->products()->count() }} item(s)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.sizes.index') }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Atualizar Tamanho
                </button>
            </div>
        </form>
    </div>
</div>
@endsection