<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    protected $fillable = [
        'user_id',
        'nis',
        'kelas',
        'alamat',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function siswa()
    {
        return $this->belongsToMany(
            Siswa::class,
            'kelas_siswa',
            'kelas_id',
            'user_id'
        )->withTimestamps();
    }

    public function pengumpulan()
    {
        return $this->hasMany(PengumpulanTugas::class, 'siswa_id');
    }

    public function permintaanJoin()
    {
        return $this->hasMany(Permintaan_Join::class, 'siswa_id');
    }

    public function getFotoUrlAttribute()
    {
        return $this->foto
            ? asset('storage/foto/' . $this->foto)
            : asset('default.png');
    }
}
