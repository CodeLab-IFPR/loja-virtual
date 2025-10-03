@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Gerenciar Clientes</h1>
        </div>

        <!-- Estatísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-sm text-blue-600">Total</p>
                        <p class="text-2xl font-bold text-blue-700">{{ $stats['total'] }}</p>
                    </div>
                    <div class="text-blue-400">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-sm text-yellow-600">Pendentes</p>
                        <p class="text-2xl font-bold text-yellow-700">{{ $stats['pending'] }}</p>
                    </div>
                    <div class="text-yellow-400">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-sm text-green-600">Aprovados</p>
                        <p class="text-2xl font-bold text-green-700">{{ $stats['approved'] }}</p>
                    </div>
                    <div class="text-green-400">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-sm text-red-600">Rejeitados</p>
                        <p class="text-2xl font-bold text-red-700">{{ $stats['rejected'] }}</p>
                    </div>
                    <div class="text-red-400">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros e Busca -->
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-64">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                    <input type="text" 
                           id="search" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Nome ou email..."
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="min-w-48">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select id="status" 
                            name="status" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Todos</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendentes</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Aprovados</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejeitados</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
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

        @if(session('warning'))
            <div class="mb-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded">
                {{ session('warning') }}
            </div>
        @endif

        <!-- Ações em Lote -->
        <div x-data="{ selectedUsers: [], showBulkActions: false }" class="mb-4">
            <div x-show="selectedUsers.length > 0" class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-blue-800">
                        <span x-text="selectedUsers.length"></span> cliente(s) selecionado(s)
                    </span>
                    <div class="flex space-x-2">
                        <button @click="bulkApprove()" 
                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                            Aprovar Selecionados
                        </button>
                        <button @click="bulkReject()" 
                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                            Rejeitar Selecionados
                        </button>
                        <button @click="selectedUsers = []" 
                                class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-sm">
                            Limpar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tabela -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox" 
                                       @change="toggleAll($event)"
                                       class="rounded border-gray-300">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cliente
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cadastrado em
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" 
                                           :value="'{{ $user->id }}'"
                                           x-model="selectedUsers"
                                           class="rounded border-gray-300">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-700">
                                                    {{ substr($user->name, 0, 1) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->status === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pendente
                                        </span>
                                    @elseif($user->status === 'approved')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Aprovado
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Rejeitado
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="text-blue-600 hover:text-blue-900">Ver</a>
                                        
                                        @if($user->status === 'pending')
                                            <button onclick="approveUser({{ $user->id }})" 
                                                    class="text-green-600 hover:text-green-900">Aprovar</button>
                                            <button onclick="rejectUser({{ $user->id }})" 
                                                    class="text-red-600 hover:text-red-900">Rejeitar</button>
                                        @elseif($user->status === 'approved')
                                            <button onclick="rejectUser({{ $user->id }})" 
                                                    class="text-red-600 hover:text-red-900">Rejeitar</button>
                                        @else
                                            <button onclick="approveUser({{ $user->id }})" 
                                                    class="text-green-600 hover:text-green-900">Aprovar</button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Nenhum cliente encontrado.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            @if($users->hasPages())
                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            @endif

            <script>
                function toggleAll(event) {
                    const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
                    const isChecked = event.target.checked;
                    
                    this.selectedUsers = isChecked ? 
                        Array.from(checkboxes).map(cb => cb.value) : 
                        [];
                }

                function bulkApprove() {
                    if (this.selectedUsers.length === 0) return;
                    
                    if (confirm(`Aprovar ${this.selectedUsers.length} cliente(s)?`)) {
                        bulkAction('approve');
                    }
                }

                function bulkReject() {
                    if (this.selectedUsers.length === 0) return;
                    
                    if (confirm(`Rejeitar ${this.selectedUsers.length} cliente(s)?`)) {
                        bulkAction('reject');
                    }
                }

                function bulkAction(action) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route('admin.users.bulk-action') }}';
                    
                    // CSRF Token
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = '{{ csrf_token() }}';
                    form.appendChild(csrfInput);
                    
                    // Action
                    const actionInput = document.createElement('input');
                    actionInput.type = 'hidden';
                    actionInput.name = 'action';
                    actionInput.value = action;
                    form.appendChild(actionInput);
                    
                    // Users
                    this.selectedUsers.forEach(userId => {
                        const userInput = document.createElement('input');
                        userInput.type = 'hidden';
                        userInput.name = 'users[]';
                        userInput.value = userId;
                        form.appendChild(userInput);
                    });
                    
                    document.body.appendChild(form);
                    form.submit();
                }

                function approveUser(userId) {
                    if (confirm('Aprovar este cliente?')) {
                        fetch(`/admin/users/${userId}/approve`, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
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
                }

                function rejectUser(userId) {
                    if (confirm('Rejeitar este cliente?')) {
                        fetch(`/admin/users/${userId}/reject`, {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
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
                }
            </script>
        </div>
    </div>
</div>
@endsection