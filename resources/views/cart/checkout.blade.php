<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Finalizar Pedido</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg">
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('cart.place-order') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <!-- Left: Address + Payment + Notes -->
                    <div class="lg:col-span-2 space-y-6">

                        <!-- Delivery Address -->
                        <div class="bg-white rounded-xl shadow p-6">
                            <h3 class="font-bold text-gray-800 text-lg mb-4">Endereço de Entrega</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Rua / Avenida *</label>
                                    <input type="text" name="street" value="{{ old('street') }}" required
                                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('street') border-red-500 @enderror">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Número *</label>
                                    <input type="text" name="number" value="{{ old('number') }}" required
                                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('number') border-red-500 @enderror">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Complemento</label>
                                    <input type="text" name="complement" value="{{ old('complement') }}"
                                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Bairro *</label>
                                    <input type="text" name="neighborhood" value="{{ old('neighborhood') }}" required
                                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('neighborhood') border-red-500 @enderror">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Cidade *</label>
                                    <input type="text" name="city" value="{{ old('city') }}" required
                                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('city') border-red-500 @enderror">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
                                    <input type="text" name="state" value="{{ old('state') }}" required maxlength="2" placeholder="PR"
                                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('state') border-red-500 @enderror">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">CEP *</label>
                                    <input type="text" name="zip_code" value="{{ old('zip_code') }}" required placeholder="00000-000"
                                        class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none @error('zip_code') border-red-500 @enderror">
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-white rounded-xl shadow p-6">
                            <h3 class="font-bold text-gray-800 text-lg mb-4">Forma de Pagamento</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach([
                                    'pix'           => ['label' => 'PIX',                    'desc' => 'Transferência instantânea'],
                                    'transfer'      => ['label' => 'Transferência Bancária',  'desc' => 'TED / DOC'],
                                    'cash_delivery' => ['label' => 'Dinheiro na Entrega',     'desc' => 'Troco se necessário'],
                                    'card_delivery' => ['label' => 'Cartão na Entrega',       'desc' => 'Débito ou crédito'],
                                    'check'         => ['label' => 'Cheque',                  'desc' => 'Sujeito a aprovação'],
                                ] as $value => $info)
                                <label class="flex items-start gap-3 p-3 border rounded-lg cursor-pointer hover:border-blue-400 transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                    <input type="radio" name="payment_method" value="{{ $value }}"
                                        {{ old('payment_method') === $value ? 'checked' : '' }}
                                        class="mt-1 text-blue-600 focus:ring-blue-400" required>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-sm">{{ $info['label'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $info['desc'] }}</p>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                            @error('payment_method')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Customer Notes -->
                        <div class="bg-white rounded-xl shadow p-6">
                            <h3 class="font-bold text-gray-800 text-lg mb-4">Observações</h3>
                            <textarea name="customer_notes" rows="3" placeholder="Informações adicionais para o pedido (opcional)…"
                                class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none resize-none">{{ old('customer_notes') }}</textarea>
                        </div>

                        <!-- Notice -->
                        <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-800">
                            <p class="font-semibold mb-1">⚠ Importante</p>
                            <p>Após confirmar, o estabelecimento verificará a disponibilidade, aprovará o pedido e informará o prazo de entrega.</p>
                        </div>
                    </div>

                    <!-- Right: Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-xl shadow p-6 sticky top-6">
                            <h3 class="font-bold text-gray-800 text-lg mb-4">Resumo do Pedido</h3>
                            <div class="space-y-3 mb-4">
                                @foreach($items as $item)
                                <div class="flex items-center gap-3">
                                    @if($item->product->first_image_url)
                                        <img src="{{ $item->product->first_image_url }}" class="h-10 w-10 object-cover rounded border" alt="">
                                    @else
                                        <div class="h-10 w-10 bg-gray-100 rounded border"></div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate">{{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-500">Qtd: {{ $item->quantity }}</p>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-900 whitespace-nowrap">
                                        R$ {{ number_format($item->product->price * $item->quantity, 2, ',', '.') }}
                                    </p>
                                </div>
                                @endforeach
                            </div>
                            <div class="border-t pt-3">
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span>Subtotal</span>
                                    <span>R$ {{ number_format($total, 2, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600 mb-3">
                                    <span>Frete</span>
                                    <span class="text-green-600 font-medium">A combinar</span>
                                </div>
                                <div class="flex justify-between text-lg font-bold text-gray-900">
                                    <span>Total</span>
                                    <span>R$ {{ number_format($total, 2, ',', '.') }}</span>
                                </div>
                            </div>
                            <button type="submit"
                                class="mt-6 w-full bg-[#062035] text-white py-3 px-6 rounded-lg font-semibold hover:bg-[#0a3a5c] transition">
                                Confirmar Pedido
                            </button>
                            <a href="{{ route('cart.index') }}" class="block text-center mt-3 text-sm text-gray-500 hover:underline">
                                &larr; Voltar ao carrinho
                            </a>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-app-layout>
