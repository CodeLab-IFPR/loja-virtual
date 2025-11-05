@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

    <div class="p-6 border-b-2 border-gray-400">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Nova Cor</h1>
                <p class="text-sm text-gray-600 mt-1">Cadastre uma nova cor de produto</p>
            </div>
            <a href="{{ route('admin.colors.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition-colors duration-200">
                ← Voltar
            </a>
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

        <form action="{{ route('admin.colors.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <!-- Informações Básicas -->
                <div class="space-y-6">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                        Informações Básicas
                    </h3>

                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nome da Cor <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                            placeholder="Ex: Azul Marinho, Vermelho Cereja"
                            class="px-4 py-3 mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">
                        <p class="mt-2 text-xs text-gray-500">O slug será gerado automaticamente baseado no nome.</p>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Descrição
                        </label>
                        <textarea id="description" name="description" rows="4"
                            placeholder="Adicione uma descrição opcional para esta cor..."
                            class="px-4 py-3 mt-1 block w-full rounded-lg border-2 border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-colors duration-200">{{ old('description') }}</textarea>
                        <p class="mt-2 text-xs text-gray-500">Descrição opcional da cor.</p>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="active" value="1" {{ old('active', true) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-700">Cor ativa</span>
                        </label>
                        <p class="mt-1 text-sm text-gray-500">Cores inativas não aparecem no catálogo público.</p>
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.colors.index') }}"
                    class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancelar
                </a>
                <button type="submit"
                    class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Criar Cor
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