<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kelas',
        'kode_kelas',
        'deskripsi',
        'wali_kelas',
        'tingkat',
        'status',
    ];

    public function murids()
    {
        return $this->hasMany(Murid::class);
    }

    public function getTotalMuridAttribute()
    {
        return $this->murids()->count();
    }
}
