<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

// IMPORT MODEL RELASI
use App\Models\User;
use App\Models\Mapel;
use App\Models\Tugas;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'kode_kelas',
        'guru_id',
    ];

    // OPTIONAL: casting biar rapi di JSON
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | AUTO GENERATE KODE KELAS
    |--------------------------------------------------------------------------
    */
    protected static function booted()
    {
        static::creating(function ($kelas) {
            if (empty($kelas->kode_kelas)) {
                $kelas->kode_kelas = strtoupper(Str::random(6));
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    // Relasi ke guru (user)
    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    // Relasi ke mapel (many to many)
    public function mapel()
    {
        return $this->belongsToMany(
            Mapel::class,
            'kelas_mapel',
            'kelas_id',
            'mapel_id'
        )->withTimestamps();
    }

    // Relasi ke siswa (many to many)
    public function siswa()
    {
        return $this->belongsToMany(
            User::class,
            'kelas_siswa',
            'kelas_id',
            'user_id'
        )->withTimestamps();
    }

    // Relasi ke tugas
    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'kelas_id');
    }
}
