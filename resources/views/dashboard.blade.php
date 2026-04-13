<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Olá, {{ Auth::user()->name }} 👋
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif

            <!-- Summary Cards -->
            @php
                $orders = Auth::user()->orders()->latest()->limit(5)->get();
                $totalOrders = Auth::user()->orders()->count();
                $pendingOrders = Auth::user()->orders()->whereIn('status', ['pending', 'processing'])->count();
                $totalSpent = Auth::user()->orders()->whereIn('status', ['delivered'])->sum('total');
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="h-7 w-7 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalOrders }}</p>
                        <p class="text-sm text-gray-500">Total de pedidos</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                    <div class="p-3 bg-amber-100 rounded-full">
                        <svg class="h-7 w-7 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $pendingOrders }}</p>
                        <p class="text-sm text-gray-500">Pedidos em andamento</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="h-7 w-7 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">R$ {{ number_format($totalSpent, 2, ',', '.') }}</p>
                        <p class="text-sm text-gray-500">Total em compras</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="flex flex-wrap gap-3 mb-8">
                <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 bg-[#062035] text-white px-5 py-2.5 rounded-lg font-semibold hover:bg-[#0a3a5c] transition text-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
                    Ver Catálogo
                </a>
                <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 bg-white border text-gray-700 px-5 py-2.5 rounded-lg font-semibold hover:bg-gray-50 transition text-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Meu Carrinho
                </a>
                <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 bg-white border text-gray-700 px-5 py-2.5 rounded-lg font-semibold hover:bg-gray-50 transition text-sm">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Meus Pedidos
                </a>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b">
                    <h3 class="font-bold text-gray-800">Pedidos Recentes</h3>
                    <a href="{{ route('orders.index') }}" class="text-sm text-blue-600 hover:underline">Ver todos</a>
                </div>
                @if($orders->isEmpty())
                    <div class="p-10 text-center text-gray-500">
                        <p>Você ainda não fez nenhum pedido.</p>
                        <a href="{{ route('catalog') }}" class="mt-3 inline-block text-blue-600 hover:underline text-sm">Explorar catálogo →</a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left px-6 py-3 text-gray-600 font-semibold">Pedido</th>
                                    <th class="text-left px-4 py-3 text-gray-600 font-semibold">Data</th>
                                    <th class="text-left px-4 py-3 text-gray-600 font-semibold">Status</th>
                                    <th class="text-right px-4 py-3 text-gray-600 font-semibold">Total</th>
                                    <th class="px-4 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($orders as $order)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-3 font-mono text-gray-700 font-medium">{{ $order->order_number }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3">
                                        @include('orders._status_badge', ['status' => $order->status])
                                    </td>
                                    <td class="px-4 py-3 text-right font-semibold text-gray-900">
                                        R$ {{ number_format($order->total, 2, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:underline text-xs">Ver</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

