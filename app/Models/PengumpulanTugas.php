<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tugas;
use App\Models\User;

class PengumpulanTugas extends Model
{
    protected $table = 'pengumpulan_tugas';

    protected $fillable = [
        'tugas_id',
        'siswa_id',
        'kelompok_id',
        'file',
        'catatan',
        'status',
        'nilai',
    ];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    public function siswa()
    {
        return $this->belongsTo(\App\Models\User::class, 'siswa_id');
    }
}
