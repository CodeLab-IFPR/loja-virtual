<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pedido {{ $order->order_number }}
            </h2>
            <a href="{{ route('orders.index') }}" class="text-sm text-gray-600 hover:underline">&larr; Meus Pedidos</a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Status Timeline -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-bold text-gray-800 mb-5">Acompanhamento do Pedido</h3>
                @php
                    $timeline = [
                        ['status' => 'pending',    'label' => 'Pedido Realizado',      'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['status' => 'accepted',   'label' => 'Pedido Aceito',          'icon' => 'M5 13l4 4L19 7'],
                        ['status' => 'processing', 'label' => 'Em Processamento',       'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['status' => 'shipped',    'label' => 'Enviado',                'icon' => 'M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z'],
                        ['status' => 'delivered',  'label' => 'Entregue',               'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ];
                    $flowStatuses = ['pending', 'accepted', 'processing', 'shipped', 'delivered'];
                    $isSpecial = in_array($order->status, ['rejected', 'cancelled']);
                    $currentIdx = array_search($order->status, $flowStatuses);
                @endphp

                @if($isSpecial)
                    <div class="flex items-center gap-3 p-4 rounded-lg {{ $order->status === 'rejected' ? 'bg-red-50 text-red-800' : 'bg-gray-100 text-gray-600' }}">
                        <svg class="h-6 w-6 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="font-semibold">Pedido {{ $order->status === 'rejected' ? 'Recusado' : 'Cancelado' }}</p>
                    </div>
                @else
                    <div class="flex items-center">
                        @foreach($timeline as $i => $step)
                            @php
                                $stepIdx = array_search($step['status'], $flowStatuses);
                                $done = $currentIdx !== false && $stepIdx <= $currentIdx;
                                $active = $order->status === $step['status'];
                            @endphp
                            <div class="flex flex-col items-center {{ $i < count($timeline) - 1 ? 'flex-1' : '' }}">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center
                                    {{ $active ? 'bg-[#062035] text-white ring-4 ring-blue-200' : ($done ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-400') }}">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/>
                                    </svg>
                                </div>
                                <p class="text-xs mt-1 text-center {{ $active ? 'font-bold text-[#062035]' : ($done ? 'text-green-700' : 'text-gray-400') }}">
                                    {{ $step['label'] }}
                                </p>
                            </div>
                            @if($i < count($timeline) - 1)
                                <div class="flex-1 h-1 {{ $done && array_search($timeline[$i+1]['status'], $flowStatuses) <= $currentIdx ? 'bg-green-400' : 'bg-gray-200' }} -mt-4 mx-1"></div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h3 class="font-bold text-gray-800">Itens do Pedido</h3>
                </div>
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="text-left px-6 py-3 text-gray-600 font-semibold">Produto</th>
                            <th class="text-center px-4 py-3 text-gray-600 font-semibold">Qtd</th>
                            <th class="text-right px-4 py-3 text-gray-600 font-semibold">Preço unit.</th>
                            <th class="text-right px-6 py-3 text-gray-600 font-semibold">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="px-6 py-3">
                                <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                                <p class="text-xs text-gray-400">SKU: {{ $item->product_sku }}</p>
                            </td>
                            <td class="px-4 py-3 text-center text-gray-700">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-right text-gray-700">R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                            <td class="px-6 py-3 text-right font-semibold text-gray-900">R$ {{ number_format($item->total_price, 2, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50 border-t">
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-right text-gray-600 font-semibold">Total</td>
                            <td class="px-6 py-3 text-right text-lg font-bold text-gray-900">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Details: Payment + Address -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="font-bold text-gray-800 mb-3">Pagamento</h3>
                    <p class="text-gray-700">{{ $order->payment_label }}</p>
                </div>
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="font-bold text-gray-800 mb-3">Endereço de Entrega</h3>
                    @php $addr = $order->billing_address; @endphp
                    <address class="not-italic text-gray-700 text-sm leading-relaxed">
                        {{ $addr['street'] ?? '' }}, {{ $addr['number'] ?? '' }}
                        @if(!empty($addr['complement'])) — {{ $addr['complement'] }}@endif<br>
                        {{ $addr['neighborhood'] ?? '' }} — {{ $addr['city'] ?? '' }}/{{ $addr['state'] ?? '' }}<br>
                        CEP: {{ $addr['zip_code'] ?? '' }}
                    </address>
                </div>
            </div>

            @if($order->customer_notes)
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-bold text-gray-800 mb-2">Observações</h3>
                <p class="text-gray-700 text-sm">{{ $order->customer_notes }}</p>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
