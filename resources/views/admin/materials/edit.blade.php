@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
        <div class="px-8 py-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Editar Material</h1>
                    <p class="mt-2 text-sm text-gray-600">Atualize as informações do material</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.materials.show', $material) }}"
                        class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg transition-colors duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Ver Material
                    </a>
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

        <form action="{{ route('admin.materials.update', $material) }}" method="POST" enctype="multipart/form-data"
            class="px-8 py-8">
            @csrf
            @method('PUT')

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
                            <input type="text" id="name" name="name" value="{{ old('name', $material->name) }}" required
                                placeholder="Ex: Couro Legítimo, Algodão, Poliéster..."
                                class="px-4 py-3 mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">
                            <p class="mt-2 text-xs text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Slug atual: <code
                                    class="ml-1 px-2 py-0.5 bg-gray-200 rounded">{{ $material->slug }}</code>
                            </p>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Descrição
                            </label>
                            <textarea id="description" name="description" rows="5"
                                placeholder="Descreva as características e benefícios deste material..."
                                class="px-4 py-3 mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200 resize-none">{{ old('description', $material->description) }}</textarea>
                            <p class="mt-2 text-xs text-gray-500">Descrição opcional do material (ajuda os clientes a
                                entenderem melhor)</p>
                        </div>

                        <div class="bg-white p-4 rounded-lg border-2 border-gray-200">
                            <label class="flex items-start cursor-pointer group">
                                <input type="checkbox" name="active" value="1"
                                    {{ old('active', $material->active) ? 'checked' : '' }}
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

                        <!-- Informações Adicionais -->
                        <div class="bg-blue-50 p-4 rounded-lg border-2 border-blue-200">
                            <h3 class="text-sm font-semibold text-blue-900 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Informações do Registro
                            </h3>
                            <div class="space-y-2 text-sm text-blue-800">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <strong>Criado em:</strong>
                                    <span class="ml-1">{{ $material->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    <strong>Última atualização:</strong>
                                    <span class="ml-1">{{ $material->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Atualizar Material
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Gerar slug automaticamente
document.getElementById('name').addEventListener('input', function(e) {
    console.log('Slug será:', e.target.value.toLowerCase().replace(/[^a-z0-9]+/g, '-'));
});
</script>
@endsection