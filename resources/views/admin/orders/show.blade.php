@extends('layouts.admin')

@section('content')
<div class="py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:underline">&larr; Pedidos</a>
                <h1 class="text-2xl font-bold text-gray-800 mt-1">{{ $order->order_number }}</h1>
            </div>
            <div class="flex items-center gap-2">
                @include('orders._status_badge', ['status' => $order->status])
                <span class="text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</span>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg text-sm">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg text-sm">{{ session('error') }}</div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left: Items + Notes -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Order Items -->
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b">
                        <h3 class="font-bold text-gray-800">Itens do Pedido</h3>
                    </div>
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left px-6 py-3 text-gray-600 font-semibold">Produto</th>
                                <th class="text-center px-4 py-3 text-gray-600 font-semibold">Qtd</th>
                                <th class="text-right px-4 py-3 text-gray-600 font-semibold">Unit.</th>
                                <th class="text-right px-4 py-3 text-gray-600 font-semibold">Subtotal</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y" id="items-body">
                            @foreach($order->items as $item)
                            <tr x-data="{ editing: false, qty: {{ $item->quantity }}, price: {{ $item->unit_price }} }">
                                <td class="px-6 py-3">
                                    <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span x-show="!editing">{{ $item->quantity }}</span>
                                    <input x-show="editing" x-model="qty" type="number" min="1"
                                        form="edit-item-{{ $item->id }}" name="quantity"
                                        class="w-16 border rounded px-2 py-1 text-center text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                                </td>
                                <td class="px-4 py-3 text-right text-gray-700">
                                    <span x-show="!editing">R$ {{ number_format($item->unit_price, 2, ',', '.') }}</span>
                                    <input x-show="editing" x-model="price" type="number" min="0" step="0.01"
                                        form="edit-item-{{ $item->id }}" name="unit_price"
                                        class="w-24 border rounded px-2 py-1 text-right text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                                </td>
                                <td class="px-4 py-3 text-right font-semibold text-gray-900">
                                    <span x-show="!editing">R$ {{ number_format($item->total_price, 2, ',', '.') }}</span>
                                    <span x-show="editing" x-text="'R$ ' + (parseFloat(qty||0) * parseFloat(price||0)).toFixed(2).replace('.',',')"></span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{-- The actual form (hidden inputs provide the submitted values) --}}
                                    <form id="edit-item-{{ $item->id }}"
                                        action="{{ route('admin.orders.items.update', [$order, $item]) }}"
                                        method="POST" class="hidden">
                                        @csrf @method('PATCH')
                                    </form>
                                    <div x-show="!editing" class="inline-flex gap-2">
                                        <button type="button" @click="editing=true" class="text-blue-600 hover:underline text-xs">Editar</button>
                                        <form action="{{ route('admin.orders.items.destroy', [$order, $item]) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Remover este item do pedido?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-xs">Remover</button>
                                        </form>
                                    </div>
                                    <div x-show="editing" class="inline-flex gap-2">
                                        <button type="submit" form="edit-item-{{ $item->id }}" class="text-green-700 font-semibold hover:underline text-xs">Salvar</button>
                                        <button type="button" @click="editing=false" class="text-gray-500 hover:underline text-xs">Cancelar</button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 border-t">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right text-gray-500">Subtotal</td>
                                <td class="px-4 py-3 text-right text-gray-700">R$ {{ number_format($order->subtotal, 2, ',', '.') }}</td>
                                <td></td>
                            </tr>
                            @if($order->discount > 0)
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right text-green-700 font-medium">Desconto</td>
                                <td class="px-4 py-3 text-right text-green-700 font-medium">− R$ {{ number_format($order->discount, 2, ',', '.') }}</td>
                                <td></td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-right text-gray-700 font-semibold">Total</td>
                                <td class="px-4 py-3 text-right text-lg font-bold text-gray-900">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

                    <!-- Add Item -->
                    <div class="px-6 py-4 border-t bg-gray-50" x-data="{ open: false }">
                        <button type="button" @click="open = !open" class="text-sm text-blue-600 hover:underline font-medium">
                            + Adicionar item
                        </button>
                        <form x-show="open" x-transition action="{{ route('admin.orders.items.add', $order) }}" method="POST"
                            class="mt-3 flex flex-wrap gap-3 items-end">
                            @csrf
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Produto</label>
                                <select name="product_id" required class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                                    <option value="">Selecionar…</option>
                                    @foreach(\App\Models\Product::where('active', true)->orderBy('name')->get() as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }} (R$ {{ number_format($product->price, 2, ',', '.') }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Qtd</label>
                                <input type="number" name="quantity" value="1" min="1" class="w-20 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                            </div>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">Adicionar</button>
                        </form>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Cliente</h3>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div><p class="text-gray-500 text-xs">Nome</p><p class="font-medium">{{ $order->user->name }}</p></div>
                        <div><p class="text-gray-500 text-xs">E-mail</p><p class="font-medium">{{ $order->user->email }}</p></div>
                        <div><p class="text-gray-500 text-xs">Telefone</p><p class="font-medium">{{ $order->user->phone ?? '—' }}</p></div>
                        <div><p class="text-gray-500 text-xs">Pagamento</p><p class="font-medium">{{ $order->payment_label }}</p></div>
                    </div>
                    @if($order->billing_address)
                    @php $addr = $order->billing_address; @endphp
                    <div class="mt-4 pt-4 border-t">
                        <p class="text-gray-500 text-xs mb-1">Endereço de Entrega</p>
                        <address class="not-italic text-sm text-gray-700 leading-relaxed">
                            {{ $addr['street'] ?? '' }}, {{ $addr['number'] ?? '' }}
                            @if(!empty($addr['complement'])) — {{ $addr['complement'] }}@endif<br>
                            {{ $addr['neighborhood'] ?? '' }} — {{ $addr['city'] ?? '' }}/{{ $addr['state'] ?? '' }}<br>
                            CEP: {{ $addr['zip_code'] ?? '' }}
                        </address>
                    </div>
                    @endif
                    @if($order->customer_notes)
                    <div class="mt-4 pt-4 border-t">
                        <p class="text-gray-500 text-xs mb-1">Observações do Cliente</p>
                        <p class="text-sm text-gray-700">{{ $order->customer_notes }}</p>
                    </div>
                    @endif
                </div>

                <!-- Admin Notes -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Notas Internas</h3>
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                        @csrf @method('PATCH')
                        <textarea name="admin_notes" rows="4"
                            class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none resize-none"
                            placeholder="Notas administrativas (visíveis apenas para a equipe)…">{{ $order->admin_notes }}</textarea>
                        <div class="mt-3 flex flex-wrap items-end gap-3">
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Pagamento</label>
                                <select name="payment_method" class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                                    <option value="">— Selecionar —</option>
                                    @foreach(\App\Models\Order::$paymentLabels as $val => $lbl)
                                        <option value="{{ $val }}" {{ $order->payment_method === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Desconto (R$)</label>
                                <input type="number" name="discount" min="0" step="0.01"
                                    value="{{ number_format((float)$order->discount, 2, '.', '') }}"
                                    class="w-28 border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                            </div>
                            <button type="submit" class="bg-gray-800 text-white px-5 py-2 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">
                                Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right: Actions -->
            <div class="space-y-6">

                <!-- Status Panel -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Ações do Pedido</h3>
                    <div class="space-y-2">
                        @php
                            $actions = [
                                'accepted'   => ['label' => 'Aceitar Pedido',      'color' => 'bg-green-600 hover:bg-green-700'],
                                'rejected'   => ['label' => 'Recusar Pedido',      'color' => 'bg-red-600 hover:bg-red-700'],
                                'processing' => ['label' => 'Marcar em Processo',  'color' => 'bg-blue-600 hover:bg-blue-700'],
                                'shipped'    => ['label' => 'Marcar como Enviado', 'color' => 'bg-indigo-600 hover:bg-indigo-700'],
                                'delivered'  => ['label' => 'Marcar como Entregue','color' => 'bg-teal-600 hover:bg-teal-700'],
                                'cancelled'  => ['label' => 'Cancelar Pedido',     'color' => 'bg-gray-500 hover:bg-gray-600'],
                                'pending'    => ['label' => 'Reabrir Pedido',      'color' => 'bg-yellow-500 hover:bg-yellow-600'],
                            ];
                            // Only show transitions that make sense for the current status
                            $allowed = match($order->status) {
                                'pending'    => ['accepted', 'rejected', 'cancelled'],
                                'accepted'   => ['processing', 'cancelled'],
                                'processing' => ['shipped', 'cancelled'],
                                'shipped'    => ['delivered', 'cancelled'],
                                'delivered'  => [],
                                'rejected'   => [],
                                'cancelled'  => ['pending'],
                                default      => array_keys($actions),
                            };
                        @endphp
                        @foreach($actions as $status => $action)
                            @if(in_array($status, $allowed))
                            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="{{ $status }}">
                                <button type="submit"
                                    class="w-full text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition {{ $action['color'] }}"
                                    @if(in_array($status, ['rejected', 'cancelled'])) onclick="return confirm('Tem certeza?')" @endif>
                                    {{ $action['label'] }}
                                </button>
                            </form>
                            @endif
                        @endforeach
                        @if(empty($allowed))
                            <p class="text-sm text-gray-400 italic text-center">Nenhuma ação disponível para este status.</p>
                        @endif
                    </div>
                </div>

                <!-- Timestamps -->
                <div class="bg-white rounded-xl shadow p-6 text-sm space-y-3">
                    <h3 class="font-bold text-gray-800 mb-2">Datas</h3>
                    <div class="flex justify-between"><span class="text-gray-500">Criado</span><span>{{ $order->created_at->format('d/m/Y H:i') }}</span></div>
                    @if($order->accepted_at)
                    <div class="flex justify-between"><span class="text-gray-500">Aceito</span><span>{{ $order->accepted_at->format('d/m/Y H:i') }}</span></div>
                    @endif
                    @if($order->rejected_at)
                    <div class="flex justify-between text-red-600"><span>Recusado</span><span>{{ $order->rejected_at->format('d/m/Y H:i') }}</span></div>
                    @endif
                    @if($order->shipped_at)
                    <div class="flex justify-between"><span class="text-gray-500">Enviado</span><span>{{ $order->shipped_at->format('d/m/Y H:i') }}</span></div>
                    @endif
                    @if($order->delivered_at)
                    <div class="flex justify-between"><span class="text-gray-500">Entregue</span><span>{{ $order->delivered_at->format('d/m/Y H:i') }}</span></div>
                    @endif
                    @if($order->cancelled_at)
                    <div class="flex justify-between text-gray-500"><span>Cancelado</span><span>{{ $order->cancelled_at->format('d/m/Y H:i') }}</span></div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
