<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Data referensi tetap (id 1 = admin, 2 = petugas, 3 = masyarakat) sesuai logika aplikasi.
        $roles = [
            ['name' => 'admin',      'display_name' => 'Administrator'],
            ['name' => 'petugas',    'display_name' => 'Petugas Kebersihan'],
            ['name' => 'masyarakat', 'display_name' => 'Masyarakat'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
