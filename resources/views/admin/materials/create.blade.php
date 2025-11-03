@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Novo Material</h1>
            <a href="{{ route('admin.materials.index') }}" 
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

        <form action="{{ route('admin.materials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
                <!-- Informações Básicas -->
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Nome do Material *
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required
                               class="pl-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <p class="mt-1 text-sm text-gray-500">O slug será gerado automaticamente baseado no nome.</p>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            Descrição
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="4"
                                  class="pl-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Descrição opcional do material.</p>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="active" 
                                   value="1" 
                                   {{ old('active', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-700">Material ativo</span>
                        </label>
                        <p class="mt-1 text-sm text-gray-500">Materiais inativos não aparecem no catálogo público.</p>
                    </div>
                </div>

            <!-- Botões de Ação -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.materials.index') }}" 
                   class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancelar
                </a>
                <button type="submit" 
                        class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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