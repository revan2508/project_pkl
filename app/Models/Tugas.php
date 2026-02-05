<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'tugas';

    protected $fillable = [
        'kelas_id',
        'mapel_id',
        'judul',
        'perintah',
        'deskripsi',
        'deadline',
        'tipe',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    public function isExpired(): bool
    {
        return now()->greaterThan($this->deadline);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function pengumpulan()
    {
        return $this->hasMany(PengumpulanTugas::class, 'tugas_id');
    }
}
