<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Meus Pedidos</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Filters -->
            <form method="GET" class="bg-white rounded-xl shadow p-4 mb-6 flex flex-wrap gap-3 items-end">
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
                <button type="submit" class="bg-[#062035] text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-[#0a3a5c] transition">
                    Filtrar
                </button>
                @if(request()->hasAny(['status', 'date_from', 'date_to']))
                    <a href="{{ route('orders.index') }}" class="text-sm text-gray-500 hover:underline self-center">Limpar</a>
                @endif
            </form>

            @if($orders->isEmpty())
                <div class="bg-white rounded-xl shadow p-12 text-center text-gray-500">
                    <p>Nenhum pedido encontrado.</p>
                    <a href="{{ route('catalog') }}" class="mt-3 inline-block text-blue-600 hover:underline text-sm">Ir ao catálogo →</a>
                </div>
            @else
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="text-left px-6 py-3 text-gray-600 font-semibold">Pedido</th>
                                    <th class="text-left px-4 py-3 text-gray-600 font-semibold">Data</th>
                                    <th class="text-left px-4 py-3 text-gray-600 font-semibold">Itens</th>
                                    <th class="text-left px-4 py-3 text-gray-600 font-semibold">Status</th>
                                    <th class="text-right px-4 py-3 text-gray-600 font-semibold">Total</th>
                                    <th class="px-4 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($orders as $order)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-3 font-mono text-gray-700 font-medium">{{ $order->order_number }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}</td>
                                    <td class="px-4 py-3">
                                        @include('orders._status_badge', ['status' => $order->status])
                                    </td>
                                    <td class="px-4 py-3 text-right font-semibold text-gray-900">
                                        R$ {{ number_format($order->total, 2, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:underline text-xs font-medium">Detalhes</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($orders->hasPages())
                        <div class="px-6 py-4 border-t">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
