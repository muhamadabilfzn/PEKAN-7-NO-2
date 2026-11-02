<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\User;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class ActivityLogSeeder extends Seeder
{
    public function run(): void
    {
        $faker   = FakerFactory::create('id_ID');
        $userIds = User::pluck('id')->all();

        for ($i = 0; $i < 20; $i++) {
            $login = $faker->boolean();

            ActivityLog::create([
                'user_id'    => $faker->randomElement($userIds),
                'aksi'       => $login ? 'login' : 'logout',
                'deskripsi'  => $login ? 'Login berhasil' : 'Logout dari sistem',
                'ip_address' => $faker->ipv4(),
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
            ]);
        }
    }
}
