@extends('layouts.admin')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Pedidos</h1>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg text-sm">{{ session('success') }}</div>
        @endif

        <!-- Filters -->
        <form method="GET" class="bg-white rounded-xl shadow p-4 mb-6 flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Buscar</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Nº pedido, cliente, e-mail…"
                    class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none w-52">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                <select name="status" class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <option value="">Todos</option>
                    @foreach(\App\Models\Order::$statusLabels as $value => $label)
                        <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">De</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                    class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Até</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                    class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">Filtrar</button>
            @if(request()->hasAny(['status', 'search', 'date_from', 'date_to']))
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:underline self-center">Limpar</a>
            @endif
        </form>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="text-left px-6 py-3 text-gray-600 font-semibold">Pedido</th>
                            <th class="text-left px-4 py-3 text-gray-600 font-semibold">Cliente</th>
                            <th class="text-left px-4 py-3 text-gray-600 font-semibold">Data</th>
                            <th class="text-left px-4 py-3 text-gray-600 font-semibold">Status</th>
                            <th class="text-left px-4 py-3 text-gray-600 font-semibold">Pagamento</th>
                            <th class="text-right px-4 py-3 text-gray-600 font-semibold">Total</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($orders as $order)
                        @php
                            $isRecent = $order->created_at->gt(now()->subHours(24)) && $order->status === 'pending';
                        @endphp
                        <tr class="hover:bg-gray-50 transition {{ $isRecent ? 'bg-yellow-50' : '' }}">
                            <td class="px-6 py-3">
                                <span class="font-mono font-medium text-gray-700">{{ $order->order_number }}</span>
                                @if($isRecent)
                                    <span class="ml-2 inline-block px-1.5 py-0.5 rounded text-xs bg-yellow-200 text-yellow-800 font-semibold">Novo</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-gray-700">
                                <p class="font-medium">{{ $order->user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $order->user->email }}</p>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-3">
                                @include('orders._status_badge', ['status' => $order->status])
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs">{{ $order->payment_label }}</td>
                            <td class="px-4 py-3 text-right font-semibold text-gray-900">
                                R$ {{ number_format($order->total, 2, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:underline text-xs font-medium">Ver</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">Nenhum pedido encontrado.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($orders->hasPages())
                <div class="px-6 py-4 border-t">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
