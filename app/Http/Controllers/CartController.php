<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $items = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $items->sum(fn($i) => $i->product->price * $i->quantity);

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request)
    {
        $user = Auth::user();

        if (! $user->isApprovedCustomer()) {
            return back()->with('error', 'Apenas clientes aprovados podem adicionar itens ao carrinho.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->manage_stock && $product->stock < $request->quantity) {
            return back()->with('error', 'Estoque insuficiente para a quantidade solicitada.');
        }

        $existing = CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        $newQty = ($existing?->quantity ?? 0) + $request->quantity;

        if ($product->manage_stock && $product->stock < $newQty) {
            return back()->with('error', 'Quantidade solicitada ultrapassa o estoque disponível.');
        }

        CartItem::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $product->id],
            ['quantity' => $newQty]
        );

        return back()->with('success', 'Produto adicionado ao carrinho!');
    }

    public function update(Request $request, CartItem $item)
    {
        $this->authorize('update', $item);

        $request->validate(['quantity' => 'required|integer|min:1']);

        $product = $item->product;

        if ($product->manage_stock && $product->stock < $request->quantity) {
            return back()->with('error', 'Estoque insuficiente para a quantidade solicitada.');
        }

        $item->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Carrinho atualizado.');
    }

    public function remove(CartItem $item)
    {
        $this->authorize('delete', $item);
        $item->delete();

        return back()->with('success', 'Item removido do carrinho.');
    }

    public function checkout()
    {
        $items = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Seu carrinho está vazio.');
        }

        $total = $items->sum(fn($i) => $i->product->price * $i->quantity);

        return view('cart.checkout', compact('items', 'total'));
    }

    public function placeOrder(Request $request)
    {
        $user = Auth::user();

        if (! $user->isApprovedCustomer()) {
            return redirect()->route('cart.index')->with('error', 'Apenas clientes aprovados podem fazer pedidos.');
        }

        $cartItems = CartItem::with('product')
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Seu carrinho está vazio.');
        }

        $request->validate([
            'street'         => 'required|string|max:255',
            'number'         => 'required|string|max:20',
            'complement'     => 'nullable|string|max:100',
            'neighborhood'   => 'required|string|max:100',
            'city'           => 'required|string|max:100',
            'state'          => 'required|string|max:2',
            'zip_code'       => 'required|string|max:9',
            'payment_method' => 'required|in:pix,transfer,cash_delivery,card_delivery,check',
            'customer_notes' => 'nullable|string|max:1000',
        ]);

        // Validate stock for all items before any change
        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;
            if ($product->manage_stock && $product->stock < $cartItem->quantity) {
                return back()->with('error', "Estoque insuficiente para o produto: {$product->name}");
            }
        }

        DB::transaction(function () use ($request, $user, $cartItems) {
            $subtotal = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);

            $address = [
                'street'       => $request->street,
                'number'       => $request->number,
                'complement'   => $request->complement,
                'neighborhood' => $request->neighborhood,
                'city'         => $request->city,
                'state'        => $request->state,
                'zip_code'     => $request->zip_code,
            ];

            $order = Order::create([
                'user_id'        => $user->id,
                'status'         => 'pending',
                'payment_method' => $request->payment_method,
                'subtotal'       => $subtotal,
                'tax'            => 0,
                'shipping'       => 0,
                'discount'       => 0,
                'total'          => $subtotal,
                'customer_notes' => $request->customer_notes,
                'billing_address' => $address,
            ]);

            foreach ($cartItems as $cartItem) {
                $product = $cartItem->product;

                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $product->id,
                    'quantity'     => $cartItem->quantity,
                    'unit_price'   => $product->price,
                    'total_price'  => $product->price * $cartItem->quantity,
                    'product_name' => $product->name,
                    'product_sku'  => $product->sku,
                ]);

                if ($product->manage_stock) {
                    $product->decrement('stock', $cartItem->quantity);
                }
            }

            CartItem::where('user_id', $user->id)->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Pedido realizado com sucesso! Aguarde a confirmação do estabelecimento.');
    }
}

