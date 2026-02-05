<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapel';

    protected $fillable = [
        'nama_mapel',
    ];

    public function kelas()
    {
        return $this->belongsToMany(
            Kelas::class,
            'kelas_mapel',
            'mapel_id',
            'kelas_id'
        )->withTimestamps();
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'mapel_id');
    }
}
