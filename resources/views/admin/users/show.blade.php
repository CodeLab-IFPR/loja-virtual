@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Detalhes do Cliente</h1>
            <a href="{{ route('admin.users.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                Voltar
            </a>
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informações do Cliente -->
            <div class="lg:col-span-2">
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações Pessoais</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nome</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Data de Cadastro</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email Verificado</label>
                            <p class="mt-1 text-sm">
                                @if($user->email_verified_at)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Verificado em {{ $user->email_verified_at->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Não verificado
                                    </span>
                                @endif
                            </p>
                        </div>
                        
                        @if($user->approved_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Aprovado em</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->approved_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Status e Ações -->
            <div class="space-y-6">
                <!-- Status Atual -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status da Conta</label>
                            <div class="mt-1">
                                @if($user->status === 'pending')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                        Aguardando Aprovação
                                    </span>
                                @elseif($user->status === 'approved')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        Aprovado
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                        Rejeitado
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pode Ver Preços</label>
                            <div class="mt-1">
                                @if($user->can_see_prices)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Sim
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Não
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ações</h3>
                    
                    <div class="space-y-3">
                        @if($user->status === 'pending')
                            <button onclick="approveUser({{ $user->id }})" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition">
                                <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Aprovar Cliente
                            </button>
                            
                            <button onclick="rejectUser({{ $user->id }})" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md transition">
                                <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                                Rejeitar Cliente
                            </button>
                        @elseif($user->status === 'approved')
                            <button onclick="rejectUser({{ $user->id }})" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md transition">
                                <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                                Rejeitar Cliente
                            </button>
                        @else
                            <button onclick="approveUser({{ $user->id }})" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition">
                                <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Aprovar Cliente
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Histórico -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Histórico</h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-2 h-2 bg-blue-400 rounded-full mt-2"></div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Cadastro realizado</p>
                                <p class="text-sm text-gray-500">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($user->email_verified_at)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-2 h-2 bg-green-400 rounded-full mt-2"></div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Email verificado</p>
                                <p class="text-sm text-gray-500">{{ $user->email_verified_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($user->approved_at)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-2 h-2 bg-green-400 rounded-full mt-2"></div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Conta aprovada</p>
                                <p class="text-sm text-gray-500">{{ $user->approved_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function approveUser(userId) {
        if (confirm('Aprovar este cliente? Ele poderá ver os preços e fazer pedidos.')) {
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
        if (confirm('Rejeitar este cliente? Ele não poderá ver preços nem fazer pedidos.')) {
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
@endsection