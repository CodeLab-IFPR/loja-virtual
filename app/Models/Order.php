<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'payment_method',
        'subtotal',
        'tax',
        'shipping',
        'total',
        'customer_notes',
        'admin_notes',
        'billing_address',
        'shipping_address',
        'shipped_at',
        'delivered_at',
        'accepted_at',
        'rejected_at',
        'cancelled_at',
        'discount',
    ];

    protected $casts = [
        'billing_address' => 'array',
        'shipping_address' => 'array',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public static array $statusLabels = [
        'pending'    => 'Aguardando',
        'processing' => 'Em Processamento',
        'accepted'   => 'Aceito',
        'rejected'   => 'Recusado',
        'shipped'    => 'Enviado',
        'delivered'  => 'Entregue',
        'cancelled'  => 'Cancelado',
    ];

    public static array $paymentLabels = [
        'pix'             => 'PIX',
        'transfer'        => 'Transferência Bancária',
        'cash_delivery'   => 'Dinheiro na Entrega',
        'card_delivery'   => 'Cartão na Entrega',
        'check'           => 'Cheque',
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::$statusLabels[$this->status] ?? $this->status;
    }

    public function getPaymentLabelAttribute(): string
    {
        return self::$paymentLabels[$this->payment_method] ?? ($this->payment_method ?? '—');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . strtoupper(uniqid());
            }
        });
    }
}
