<?php
namespace Database\Seeders;

use App\Models\User;
use DB;
// import
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{

    public function run(): void
    {
        DB::table('users')->delete();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('rahasia'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Guru',
            'email' => 'guru@gmail.com',
            'password' => bcrypt('rahasia'),
            'role' => 'guru',
        ]);

        User::create([
            'name' => 'Siswa',
            'email' => 'siswa@gmail.com',
            'password' => bcrypt('rahasia'),
            'role' => 'siswa',
        ]);

    }
}