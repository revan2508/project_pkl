<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Kelas;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // ... [fillable, hidden, casts] tetap seperti sebelumnya

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // 🟢 Tambahkan ini

    public function getRoleTextAttribute()
    {
        return ucfirst($this->role);
    }

    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    public function kelas()
    {
        return $this->belongsToMany(
            Kelas::class,
            'kelas_siswa',
            'user_id',
            'kelas_id'
        )->withTimestamps();
    }

    public function kelasGuru()
    {
        return $this->hasMany(Kelas::class, 'guru_id');
    }
}
