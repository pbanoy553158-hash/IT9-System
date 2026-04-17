<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Added 'role' to fillable so we can assign 'admin' or 'supplier'.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationship: A User has many Orders.
     * This fixes the "Call to undefined method App\Models\User::orders()" error.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }
}