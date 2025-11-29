@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Gerenciar Materiais</h1>
            <a href="{{ route('admin.materials.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                Novo Material
            </a>
        </div>

        <!-- Estatísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-sm text-blue-600">Total</p>
                        <p class="text-2xl font-bold text-blue-700">{{ $stats['total'] }}</p>
                    </div>
                    <div class="text-blue-400">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-sm text-green-600">Ativos</p>
                        <p class="text-2xl font-bold text-green-700">{{ $stats['active'] }}</p>
                    </div>
                    <div class="text-green-400">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-sm text-red-600">Inativos</p>
                        <p class="text-2xl font-bold text-red-700">{{ $stats['inactive'] }}</p>
                    </div>
                    <div class="text-red-400">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros e Busca -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('admin.materials.index') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-64">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Nome ou descrição..."
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                </div>
                <div class="min-w-48">
                    <label for="active" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="active" name="active"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2">
                        <option value="">Todos</option>
                        <option value="1" {{ request('active') === '1' ? 'selected' : '' }}>Ativos</option>
                        <option value="0" {{ request('active') === '0' ? 'selected' : '' }}>Inativos</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>

        @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
        @endif

        <!-- Tabela de Materiais -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-10 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Material
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Descrição
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Produtos
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($materials as $material)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $material->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $material->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate">
                                {{ $material->description ?: 'Sem descrição' }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($material->active)
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Ativo
                            </span>
                            @else
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Inativo
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $material->products_count ?? $material->products()->count() }} produtos
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.materials.show', $material) }}"
                                    class="text-blue-600 hover:text-blue-900">Ver</a>

                                <a href="{{ route('admin.materials.edit', $material) }}"
                                    class="text-indigo-600 hover:text-indigo-900">Editar</a>

                                <button onclick="toggleStatus('{{ $material->slug }}')"
                                    class="text-yellow-600 hover:text-yellow-900">
                                    {{ $material->active ? 'Desativar' : 'Ativar' }}
                                </button>

                                @if($material->products()->count() === 0)
                                <form action="{{ route('admin.materials.destroy', $material) }}" method="POST"
                                    class="inline"
                                    onsubmit="return confirm('Tem certeza que deseja excluir este material?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        Excluir
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Nenhum material encontrado.
                            <a href="{{ route('admin.materials.create') }}"
                                class="text-blue-600 hover:text-blue-800 ml-2">
                                Criar primeiro material
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        @if($materials->hasPages())
        <div class="mt-6">
            {{ $materials->links() }}
        </div>
        @endif
    </div>
</div>

<script>
function toggleStatus(materialSlug) {
    console.log('Toggling status for material:', materialSlug);
    fetch(`/admin/materials/${materialSlug}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            location.reload();
            if (data.success) {
                location.reload();
            } else {
                alert('Erro: ' + (data.message || 'Falha na operação'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erro na comunicação com o servidor');
        });
}
</script>
@endsection