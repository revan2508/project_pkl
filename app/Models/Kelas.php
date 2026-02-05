<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'kode_kelas',
        'guru_id',
    ];

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function mapel()
    {
        return $this->belongsToMany(
            Mapel::class,
            'kelas_mapel',
            'kelas_id',
            'mapel_id'
        )->withTimestamps();
    }

    public function siswa()
    {
        return $this->belongsToMany(
            User::class,
            'kelas_siswa',
            'kelas_id',
            'user_id'
        )->withTimestamps();
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'kelas_id');
    }
}
