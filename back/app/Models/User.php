<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role', // Add any other fields you need
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function blogs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Blog::class);
    }

    public function admin(): bool
    {
        return $this->role === 'admin';
    }

    public function publisher(): bool
    {
        return $this->role === 'publisher';
    }

    public function reader(): bool
    {
        return $this->role === 'reader';
    }
}
