<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
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

    public function isGuru()
    {
        return $this->role === 'guru';
    }

    public function isOrangTua()
    {
        return $this->role === 'orang_tua';
    }

    /**
     * Relasi ke Murid (hanya untuk role orang_tua)
     */
    public function murid()
    {
        return $this->hasMany(Murid::class, 'id_user_orangtua');
    }
}