<?php

namespace App\Models;

use App\Helpers\ImageHelper;
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
        'image',
        'images',
        'active',
        'featured',
        'category_id',
        'size_id',
        'material_id',
        'color_id',
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

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
    
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
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
        return ImageHelper::getFirstProductImage($this);
    }

    public function getFirstImageUrlAttribute()
    {
        return ImageHelper::getFirstProductImage($this);
    }

    public function getAllImagesAttribute()
    {
        return ImageHelper::getAllProductImages($this);
    }

    public function hasValidImages()
    {
        return count($this->getAllImagesAttribute()) > 0;
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
