<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Material extends Model
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

        static::creating(function ($material) {
            if (empty($material->slug)) {
                $material->slug = Str::slug($material->name);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
