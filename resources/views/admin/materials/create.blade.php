@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
        <div class="px-8 py-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Novo Material</h1>
                    <p class="mt-2 text-sm text-gray-600">Adicione um novo tipo de material ao catálogo</p>
                </div>
                <a href="{{ route('admin.materials.index') }}"
                    class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-lg transition-colors duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Voltar
                </a>
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

        <form action="{{ route('admin.materials.store') }}" method="POST" enctype="multipart/form-data"
            class="px-8 py-8">
            @csrf

            <!-- Informações Básicas -->
            <div class="space-y-8">
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Informações Básicas
                    </h2>

                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nome do Material <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                placeholder="Ex: Couro Legítimo, Algodão, Poliéster..."
                                class="px-4 py-3 mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">
                            <p class="mt-2 text-xs text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                O slug será gerado automaticamente baseado no nome
                            </p>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Descrição
                            </label>
                            <textarea id="description" name="description" rows="5"
                                placeholder="Descreva as características e benefícios deste material..."
                                class="px-4 py-3 mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 resize-none">{{ old('description') }}</textarea>
                            <p class="mt-2 text-xs text-gray-500">Descrição opcional do material (ajuda os clientes a
                                entenderem melhor)</p>
                        </div>

                        <div class="bg-white p-4 rounded-lg border-2 border-gray-200">
                            <label class="flex items-start cursor-pointer group">
                                <input type="checkbox" name="active" value="1"
                                    {{ old('active', true) ? 'checked' : '' }}
                                    class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 w-5 h-5 transition-colors duration-200">
                                <div class="ml-3">
                                    <span
                                        class="text-sm font-medium text-gray-900 group-hover:text-indigo-600 transition-colors duration-200">Material
                                        ativo</span>
                                    <p class="text-xs text-gray-500 mt-1">Materiais inativos não aparecem no catálogo
                                        público e não podem ser associados a produtos</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="flex justify-end space-x-4 pt-8 mt-8 border-t-2 border-gray-200">
                <a href="{{ route('admin.materials.index') }}"
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Criar Material
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Gerar slug automaticamente
document.getElementById('name').addEventListener('input', function(e) {
    // Aqui você pode adicionar lógica para mostrar o slug que será gerado
    console.log('Slug será:', e.target.value.toLowerCase().replace(/[^a-z0-9]+/g, '-'));
});
</script>
@endsection