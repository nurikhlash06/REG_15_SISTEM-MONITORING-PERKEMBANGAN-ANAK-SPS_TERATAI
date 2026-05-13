<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianMingguan extends Model
{
    protected $fillable = ['murid_id', 'indikator_id', 'user_id_guru', 'tanggal', 'minggu_ke', 'skor'];
}
