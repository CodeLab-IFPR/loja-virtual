@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 border-b-2 border-gray-600">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Editar Tamanho</h1>
                <p class="text-sm text-gray-600 mt-1">Atualize as informações do tamanho</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.sizes.show', $size) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors duration-200">
                    Ver Tamanho
                </a>
                <a href="{{ route('admin.sizes.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition-colors duration-200">
                    ← Voltar
                </a>
            </div>
        </div>
    </div>

    <div class="p-6">
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
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        Informações Básicas
                    </h3>

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nome do Tamanho <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $size->name) }}" required
                            placeholder="Ex: Pequeno, Médio, Grande"
                            class="px-4 py-3 mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">
                        <p class="mt-2 text-xs text-gray-500">Slug atual: <code>{{ $size->slug }}</code></p>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Descrição
                        </label>
                        <textarea id="description" name="description" rows="4"
                            placeholder="Adicione uma descrição opcional para este tamanho..."
                            class="px-4 py-3 mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">{{ old('description', $size->description) }}</textarea>
                        <p class="mt-2 text-xs text-gray-500">Descrição opcional do tamanho.</p>
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-semibold text-gray-700 mb-2">
                            Ordem de Classificação
                        </label>
                        <input type="number" id="sort_order" name="sort_order"
                            value="{{ old('sort_order', $size->sort_order) }}" placeholder="0"
                            class="px-4 py-3 mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">
                        <p class="mt-2 text-xs text-gray-500">Número para ordenação (maior número aparece primeiro).</p>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="active" value="1"
                                {{ old('active', $size->active) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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