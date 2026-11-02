<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker    = FakerFactory::create('id_ID');
        $password = Hash::make('cleanhub123'); // semua akun dummy memakai password yang sama

        // Akun demo tetap (sama seperti README)
        $demo = [
            [1, 'Admin CleanHub', 'admin',        'admin@cleanhub.id',   'L'],
            [2, 'Budi Santoso',   'budi_petugas', 'petugas@cleanhub.id', 'L'],
            [2, 'Rahmat Hidayat', 'rahmat_pet',   'rahmat@cleanhub.id',  'L'],
            [3, 'Sari Dewi',      'sari_user',    'user@cleanhub.id',    'P'],
        ];

        foreach ($demo as [$role, $nama, $username, $email, $jk]) {
            User::create([
                'role_id'       => $role,
                'nama_lengkap'  => $nama,
                'username'      => $username,
                'email'         => $email,
                'password'      => $password,
                'jenis_kelamin' => $jk,
                'tanggal_lahir' => $faker->date('Y-m-d', '-20 years'),
                'no_hp'         => $faker->phoneNumber(),
                'alamat'        => $faker->address(),
                'status'        => 'aktif',
            ]);
        }

        // 2 petugas + 10 masyarakat dari Faker
        foreach ([2 => 2, 3 => 10] as $role => $jumlah) {
            for ($i = 0; $i < $jumlah; $i++) {
                $jk = $faker->randomElement(['L', 'P']);

                User::create([
                    'role_id'       => $role,
                    'nama_lengkap'  => $faker->name($jk === 'L' ? 'male' : 'female'),
                    'username'      => $faker->unique()->userName(),
                    'email'         => $faker->unique()->safeEmail(),
                    'password'      => $password,
                    'jenis_kelamin' => $jk,
                    'tanggal_lahir' => $faker->date('Y-m-d', '-17 years'),
                    'no_hp'         => $faker->phoneNumber(),
                    'alamat'        => $faker->address(),
                    'status'        => $faker->randomElement(['aktif', 'aktif', 'aktif', 'nonaktif']),
                ]);
            }
        }
    }
}
