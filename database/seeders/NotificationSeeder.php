<?php

namespace Database\Seeders;

use App\Models\Notifikasi;
use App\Models\User;
use App\Models\WasteReport;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        $faker   = FakerFactory::create('id_ID');
        $userIds = User::whereIn('role_id', [2, 3])->pluck('id')->all();
        $maxId   = max(WasteReport::max('id'), 1);

        $template = [
            ['Laporan Diterima',       'Laporan #%d Anda telah diterima dan sedang diverifikasi.',        'info'],
            ['Laporan Diverifikasi',   'Laporan #%d Anda telah diverifikasi oleh admin.',                 'info'],
            ['Tugas Baru',             'Anda mendapat tugas baru untuk menangani laporan #%d.',           'warning'],
            ['Laporan Selesai',        'Laporan #%d Anda telah berhasil ditangani oleh petugas.',         'success'],
        ];

        for ($i = 0; $i < 15; $i++) {
            [$judul, $pesan, $tipe] = $faker->randomElement($template);

            Notifikasi::create([
                'user_id'    => $faker->randomElement($userIds),
                'judul'      => $judul,
                'pesan'      => sprintf($pesan, $faker->numberBetween(1, $maxId)),
                'tipe'       => $tipe,
                'is_read'    => $faker->boolean(50),
                'created_at' => $faker->dateTimeBetween('-30 days', 'now'),
            ]);
        }
    }
}
