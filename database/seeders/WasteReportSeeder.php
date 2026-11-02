<?php

namespace Database\Seeders;

use App\Models\Location;
use App\Models\User;
use App\Models\WasteCategory;
use App\Models\WasteReport;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class WasteReportSeeder extends Seeder
{
    public function run(): void
    {
        $faker = FakerFactory::create('id_ID');

        $userIds     = User::where('role_id', 3)->pluck('id')->all();
        $categoryIds = WasteCategory::pluck('id')->all();
        $locations   = Location::all();

        $deskripsi = [
            'Sampah menumpuk di pinggir jalan dan mulai menimbulkan bau tidak sedap.',
            'Saluran air tersumbat sampah plastik sehingga berpotensi banjir.',
            'Puing bangunan dibuang sembarangan di lahan kosong dekat permukiman.',
            'Botol dan kantong plastik berserakan di sekitar taman bermain anak.',
            'Ditemukan baterai bekas dan barang elektronik rusak di tempat sampah umum.',
            'Tumpukan sampah organik sisa pasar belum diangkut lebih dari tiga hari.',
            'Sampah campur dibuang ke pinggir sungai dan mengganggu aliran air.',
            'Tempat pembuangan sementara sudah penuh dan sampah meluber ke jalan.',
        ];

        for ($i = 0; $i < 20; $i++) {
            $lokasi  = $faker->boolean(75) ? $locations->random() : null;
            $dibuat  = $faker->dateTimeBetween('-60 days', 'now');

            WasteReport::create([
                'user_id'       => $faker->randomElement($userIds),
                'category_id'   => $faker->randomElement($categoryIds),
                'location_id'   => $lokasi?->id,
                'deskripsi'     => $faker->randomElement($deskripsi),
                'status'        => $faker->randomElement(WasteReport::STATUSES),
                'latitude'      => $lokasi?->latitude,
                'longitude'     => $lokasi?->longitude,
                'alamat_detail' => $lokasi ? $lokasi->nama_lokasi : $faker->address(),
                'iuran'         => WasteReport::IURAN,
                'is_paid'       => $faker->boolean(40),
                'created_at'    => $dibuat,
                'updated_at'    => $dibuat,
            ]);
        }
    }
}
