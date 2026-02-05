<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'gurus';

    protected $fillable = [
        'user_id',
        'nip',
        'mapel',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'guru_id');
    }

    public function getFotoUrlAttribute()
    {
        return $this->foto
            ? asset('storage/foto/' . $this->foto)
            : asset('default.png');
    }
}
