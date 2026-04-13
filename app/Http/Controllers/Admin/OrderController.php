<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                                                    ->orWhere('email', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.product');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,accepted,rejected,shipped,delivered,cancelled',
        ]);

        $newStatus = $request->status;

        DB::transaction(function () use ($order, $newStatus) {
            $data = ['status' => $newStatus];

            if ($newStatus === 'accepted') {
                $data['accepted_at'] = now();
            } elseif ($newStatus === 'rejected') {
                $data['rejected_at'] = now();
                // Restore stock on rejection
                foreach ($order->items as $item) {
                    if ($item->product && $item->product->manage_stock) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }
            } elseif ($newStatus === 'cancelled') {
                $data['cancelled_at'] = now();
                // Restore stock on cancellation (only if not already rejected/cancelled)
                if (! in_array($order->status, ['rejected', 'cancelled'])) {
                    foreach ($order->items as $item) {
                        if ($item->product && $item->product->manage_stock) {
                            $item->product->increment('stock', $item->quantity);
                        }
                    }
                }
            } elseif ($newStatus === 'pending') {
                // Reopen: clear cancellation timestamp, re-decrement stock
                $data['cancelled_at'] = null;
                foreach ($order->items as $item) {
                    if ($item->product && $item->product->manage_stock) {
                        $item->product->decrement('stock', $item->quantity);
                    }
                }
            } elseif ($newStatus === 'shipped') {
                $data['shipped_at'] = now();
            } elseif ($newStatus === 'delivered') {
                $data['delivered_at'] = now();
            }

            $order->update($data);
        });

        return back()->with('success', 'Status do pedido atualizado com sucesso.');
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'admin_notes'    => 'nullable|string|max:2000',
            'payment_method' => 'nullable|in:pix,transfer,cash_delivery,card_delivery,check',
            'discount'       => 'nullable|numeric|min:0',
        ]);

        $order->update($request->only('admin_notes', 'payment_method', 'discount'));
        $this->recalculateOrder($order);

        return back()->with('success', 'Pedido atualizado.');
    }

    public function addItem(Request $request, Order $order)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        $existing = $order->items()->where('product_id', $product->id)->first();

        if ($existing) {
            $existing->increment('quantity', $request->quantity);
            $existing->update(['total_price' => $existing->unit_price * $existing->quantity]);
        } else {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $product->id,
                'quantity'     => $request->quantity,
                'unit_price'   => $product->price,
                'total_price'  => $product->price * $request->quantity,
                'product_name' => $product->name,
                'product_sku'  => $product->sku,
            ]);
        }

        $this->recalculateOrder($order);

        return back()->with('success', 'Item adicionado ao pedido.');
    }

    public function updateItem(Request $request, Order $order, OrderItem $item)
    {
        abort_if($item->order_id !== $order->id, 404);

        $request->validate([
            'quantity'   => 'required|integer|min:1',
            'unit_price' => 'nullable|numeric|min:0',
        ]);

        $unitPrice = $request->filled('unit_price') ? (float) $request->unit_price : (float) $item->unit_price;

        $item->update([
            'quantity'    => $request->quantity,
            'unit_price'  => $unitPrice,
            'total_price' => $unitPrice * $request->quantity,
        ]);

        $this->recalculateOrder($order);

        return back()->with('success', 'Item atualizado.');
    }

    public function removeItem(Order $order, OrderItem $item)
    {
        abort_if($item->order_id !== $order->id, 404);

        $item->delete();
        $this->recalculateOrder($order);

        return back()->with('success', 'Item removido do pedido.');
    }

    private function recalculateOrder(Order $order): void
    {
        $order->refresh();
        $subtotal = $order->items()->sum('total_price');
        $order->update([
            'subtotal' => $subtotal,
            'total'    => max(0, $subtotal + $order->tax + $order->shipping - $order->discount),
        ]);
    }

    // Resource stubs (create/store/edit/destroy not needed for orders)
    public function create() { abort(404); }
    public function store(Request $request) { abort(404); }
    public function edit(Order $order) { abort(404); }
    public function destroy(Order $order) { abort(404); }
}
