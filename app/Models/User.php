<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'document',
        'user_type',
        'status',
        'can_see_prices',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'approved_at' => 'datetime',
            'password' => 'hashed',
            'can_see_prices' => 'boolean',
            'address' => 'array',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    /**
     * Check if user is approved customer
     */
    public function isApprovedCustomer()
    {
        return $this->user_type === 'customer' && $this->status === 'approved';
    }

    /**
     * Check if user can see prices
     */
    public function canSeePrices()
    {
        return $this->can_see_prices || $this->isAdmin();
    }

    /**
     * Relationship with user who approved this user
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Users approved by this user
     */
    public function approvedUsers()
    {
        return $this->hasMany(User::class, 'approved_by');
    }

    /**
     * Orders placed by this user
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Cart items for this user
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
