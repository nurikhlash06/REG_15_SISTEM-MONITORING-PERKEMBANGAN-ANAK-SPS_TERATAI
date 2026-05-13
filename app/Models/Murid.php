<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    protected $table = 'murid';

    protected $fillable = [
        'nama_lengkap',
        'jenis_kelamin',
        'tanggal_lahir',
        'nik',
        'nisn',
        'rombel',
        'kelas_id',
        'alamat',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'foto',
        'id_user_orangtua',
        'nama_orang_tua',
        'email_orang_tua',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    public function orangTuaUser()
    {
        return $this->belongsTo(User::class, 'id_user_orangtua');
    }

    public function perkembangan()
    {
        return $this->hasMany(Perkembangan::class, 'murid_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}

