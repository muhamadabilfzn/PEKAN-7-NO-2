<?php

namespace Database\Seeders;

use App\Models\SupportMessage;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class SupportMessageSeeder extends Seeder
{
    public function run(): void
    {
        $faker = FakerFactory::create('id_ID');

        for ($i = 0; $i < 10; $i++) {
            SupportMessage::create([
                'nama'   => $faker->name(),
                'email'  => $faker->safeEmail(),
                'subjek' => $faker->randomElement([
                    'Cara membuat laporan',
                    'Laporan belum diverifikasi',
                    'Lupa password akun',
                    'Jadwal pengangkutan sampah',
                    'Saran untuk CleanHub',
                ]),
                'pesan'  => $faker->realText(200),
            ]);
        }
    }
}
