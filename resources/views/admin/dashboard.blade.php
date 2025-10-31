@extends('layouts.admin')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <h1 class="text-2xl font-bold mb-6">Dashboard Administrativo</h1>
        
        <!-- Estatísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-blue-500 text-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold">Total de Clientes</h3>
                        <p class="text-2xl font-bold">{{ $stats['total_customers'] }}</p>
                    </div>
                    <div class="text-blue-200">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-yellow-500 text-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold">Aguardando Aprovação</h3>
                        <p class="text-2xl font-bold">{{ $stats['pending_customers'] }}</p>
                    </div>
                    <div class="text-yellow-200">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-green-500 text-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold">Total de Produtos</h3>
                        <p class="text-2xl font-bold">{{ $stats['total_products'] }}</p>
                    </div>
                    <div class="text-green-200">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2L3 7v11a2 2 0 002 2h10a2 2 0 002-2V7l-7-5zM8.5 13a1.5 1.5 0 103 0 1.5 1.5 0 00-3 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-purple-500 text-white p-6 rounded-lg shadow">
                <div class="flex items-center">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold">Total de Pedidos</h3>
                        <p class="text-2xl font-bold">{{ $stats['total_orders'] }}</p>
                    </div>
                    <div class="text-purple-200">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Clientes Pendentes -->
            <div class="bg-white border border-gray-200 rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Clientes Aguardando Aprovação</h3>
                </div>
                <div class="p-6">
                    @if($pending_customers->count() > 0)
                        <div class="space-y-4">
                            @foreach($pending_customers as $customer)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-semibold">{{ $customer->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $customer->email }}</p>
                                    <p class="text-xs text-gray-500">{{ $customer->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.users.show', $customer) }}" 
                                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                        Ver
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Nenhum cliente aguardando aprovação.</p>
                    @endif
                    
                    @if($pending_customers->count() > 0)
                    <div class="mt-4">
                        <a href="{{ route('admin.users.index') }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                            Ver todos os clientes →
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Pedidos Recentes -->
            <div class="bg-white border border-gray-200 rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Pedidos Recentes</h3>
                </div>
                <div class="p-6">
                    @if($recent_orders->count() > 0)
                        <div class="space-y-4">
                            @foreach($recent_orders as $order)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-semibold">Pedido #{{ $order->id }}</p>
                                    <p class="text-sm text-gray-600">{{ $order->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-green-600">R$ {{ number_format($order->total, 2, ',', '.') }}</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status == 'completed') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">Nenhum pedido encontrado.</p>
                    @endif
                    
                    @if($recent_orders->count() > 0)
                    <div class="mt-4">
                        <a href="{{ route('admin.orders.index') }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                            Ver todos os pedidos →
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Links Rápidos -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold mb-4">Ações Rápidas</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-200 transition-colors">
                    <svg class="w-6 h-6 text-blue-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                    <span class="font-semibold text-blue-700">Gerenciar Clientes</span>
                </a>
                
                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg border border-green-200 transition-colors">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2L3 7v11a2 2 0 002 2h10a2 2 0 002-2V7l-7-5zM8.5 13a1.5 1.5 0 103 0 1.5 1.5 0 00-3 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-semibold text-green-700">Gerenciar Produtos</span>
                </a>
                
                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 rounded-lg border border-purple-200 transition-colors">
                    <svg class="w-6 h-6 text-purple-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/>
                    </svg>
                    <span class="font-semibold text-purple-700">Gerenciar Categorias</span>
                </a>
                
                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg border border-yellow-200 transition-colors">
                    <svg class="w-6 h-6 text-yellow-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                    </svg>
                    <span class="font-semibold text-yellow-700">Gerenciar Pedidos</span>
                </a>

                <a href="{{ route('admin.colors.index') }}" 
                   class="flex items-center p-4 bg-pink-50 hover:bg-pink-100 rounded-lg border border-pink-200 transition-colors">
                    <svg class="w-6 h-6 text-pink-500 mr-3"  viewBox="0 0 20 20" fill="currentColor">
                        <path d="M8 5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m4 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M5.5 7a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m.5 6a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                        <path d="M16 8c0 3.15-1.866 2.585-3.567 2.07C11.42 9.763 10.465 9.473 10 10c-.603.683-.475 1.819-.351 2.92C9.826 14.495 9.996 16 8 16a8 8 0 1 1 8-8m-8 7c.611 0 .654-.171.655-.176.078-.146.124-.464.07-1.119-.014-.168-.037-.37-.061-.591-.052-.464-.112-1.005-.118-1.462-.01-.707.083-1.61.704-2.314.369-.417.845-.578 1.272-.618.404-.038.812.026 1.16.104.343.077.702.186 1.025.284l.028.008c.346.105.658.199.953.266.653.148.904.083.991.024C14.717 9.38 15 9.161 15 8a7 7 0 1 0-7 7"/>
                    </svg>
                    <span class="font-semibold text-pink-700">Gerenciar Cores</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection