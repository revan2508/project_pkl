<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';

    protected $fillable = [
        'id_user',
        'jenis',
        'judul',
        'pesan',
        'url_aksi',
        'data_tambahan',
        'sudah_dibaca',
    ];

    protected $casts = [
        'data_tambahan' => 'array',
        'sudah_dibaca'  => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function scopeBelumDibaca($query)
    {
        return $query->where('sudah_dibaca', false);
    }
}
