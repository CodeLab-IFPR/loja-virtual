<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Meu Carrinho</h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">{{ session('error') }}</div>
            @endif

            @if($items->isEmpty())
                <div class="text-center py-20">
                    <svg class="mx-auto h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <p class="text-gray-500 text-lg mb-4">Seu carrinho está vazio.</p>
                    <a href="{{ route('catalog') }}" class="inline-block bg-[#062035] text-white px-6 py-3 rounded-lg font-semibold hover:bg-[#0a3a5c] transition">Ver Catálogo</a>
                </div>
            @else
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="text-left px-6 py-3 text-gray-600 font-semibold">Produto</th>
                                <th class="text-center px-4 py-3 text-gray-600 font-semibold">Qtd</th>
                                <th class="text-right px-4 py-3 text-gray-600 font-semibold">Preço unit.</th>
                                <th class="text-right px-4 py-3 text-gray-600 font-semibold">Subtotal</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($items as $item)
                            <tr x-data="{ qty: {{ $item->quantity }} }">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        @if($item->product->first_image_url)
                                            <img src="{{ $item->product->first_image_url }}"
                                                 alt="{{ $item->product->name }}"
                                                 class="h-16 w-16 object-cover rounded-lg border">
                                        @else
                                            <div class="h-16 w-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                                <svg class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $item->product->name }}</p>
                                            <p class="text-xs text-gray-400">SKU: {{ $item->product->sku }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center justify-center gap-2">
                                        @csrf @method('PATCH')
                                        <button type="button" @click="qty = Math.max(1, qty - 1)"
                                            class="w-7 h-7 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center font-bold text-gray-700">−</button>
                                        <input type="number" name="quantity" x-model="qty"
                                            class="w-14 text-center border rounded-lg py-1 focus:ring-2 focus:ring-blue-400 focus:outline-none" min="1">
                                        <button type="button" @click="qty++"
                                            class="w-7 h-7 rounded-full bg-gray-200 hover:bg-gray-300 flex items-center justify-center font-bold text-gray-700">+</button>
                                        <button type="submit" class="ml-1 text-xs text-blue-600 underline hover:text-blue-800">OK</button>
                                    </form>
                                </td>
                                <td class="px-4 py-4 text-right text-gray-700">
                                    R$ {{ number_format($item->product->price, 2, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 text-right font-semibold text-gray-900">
                                    R$ {{ number_format($item->product->price * $item->quantity, 2, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <form action="{{ route('cart.remove', $item) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Remover">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Total + Actions -->
                <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ route('catalog') }}" class="text-sm text-gray-600 hover:underline">&larr; Continuar comprando</a>
                    <div class="flex items-center gap-6">
                        <span class="text-lg font-bold text-gray-900">
                            Total: R$ {{ number_format($total, 2, ',', '.') }}
                        </span>
                        <a href="{{ route('cart.checkout') }}"
                            class="bg-[#062035] text-white px-8 py-3 rounded-lg font-semibold hover:bg-[#0a3a5c] transition">
                            Finalizar Pedido &rarr;
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
