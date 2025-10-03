<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'specifications',
        'sku',
        'price',
        'stock',
        'manage_stock',
        'weight',
        'dimensions',
        'material',
        'color',
        'image',
        'images',
        'active',
        'featured',
        'category_id',
    ];

    protected $casts = [
        'images' => 'array',
        'active' => 'boolean',
        'featured' => 'boolean',
        'manage_stock' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function isInStock()
    {
        if (!$this->manage_stock) {
            return true;
        }
        return $this->stock > 0;
    }

    public function getFirstImageAttribute()
    {
        // Se tem imagem principal, usa ela
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        
        // Caso contrário, pega a primeira das imagens adicionais
        $images = $this->images;
        
        // Se for string (JSON), decode
        if (is_string($images)) {
            $images = json_decode($images, true) ?: [];
        }
        
        // Se não for array, retorna null
        if (!is_array($images)) {
            return null;
        }
        
        // Se tem imagens, retorna a primeira
        if (count($images) > 0) {
            return asset('storage/' . $images[0]);
        }
        
        return null;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = 'VASO-' . strtoupper(Str::random(8));
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
