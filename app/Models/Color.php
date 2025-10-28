<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Color extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function activeProductsCount()
    {
        return $this->products()->where('active', true)->count();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($color) {
            if (empty($color->slug)) {
                $color->slug = Str::slug($color->name);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
