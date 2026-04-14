<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perkembangan extends Model
{
    protected $table = 'perkembangan';

    protected $fillable = [
        'murid_id',
        'user_id_guru',
        'tanggal',
        'aspek',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function murid()
    {
        return $this->belongsTo(Murid::class, 'murid_id');
    }

    public function guruUser()
    {
        return $this->belongsTo(User::class, 'user_id_guru');
    }
}

