<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Officer;
use App\Models\User;
use App\Models\WasteReport;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class AssignmentSeeder extends Seeder
{
    public function run(): void
    {
        $faker      = FakerFactory::create('id_ID');
        $officerIds = Officer::pluck('id')->all();
        $adminId    = User::where('role_id', 1)->value('id');

        // Hanya laporan yang sudah diproses ke atas yang punya penugasan.
        $laporan = WasteReport::whereIn('status', ['diproses', 'ditangani', 'selesai'])->get();

        foreach ($laporan as $report) {
            $status   = match ($report->status) {
                'selesai' => 'selesai',
                'diproses' => $faker->randomElement(['pending', 'diterima']),
                default   => 'diterima',
            };
            $ditugaskan = $faker->dateTimeBetween($report->created_at, 'now');

            Assignment::create([
                'report_id'   => $report->id,
                'officer_id'  => $faker->randomElement($officerIds),
                'assigned_by' => $adminId,
                'catatan'     => $faker->randomElement([
                    'Bersihkan saluran air di lokasi.',
                    'Angkut tumpukan sampah sebelum pukul 10.00.',
                    'Koordinasi dengan ketua RT setempat.',
                    'Pilah sampah sebelum diangkut ke TPS.',
                ]),
                'status'      => $status,
                'assigned_at' => $ditugaskan,
                'selesai_at'  => $status === 'selesai' ? $faker->dateTimeBetween($ditugaskan, 'now') : null,
            ]);
        }
    }
}
