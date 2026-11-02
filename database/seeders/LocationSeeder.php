<?php

namespace Database\Seeders;

use App\Models\Location;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = FakerFactory::create('id_ID');

        $kecamatan = [
            'Arcamanik'  => ['Cisaranten Endah', 'Cisaranten Kidul', 'Sukamiskin', 'Sindangjaya'],
            'Antapani'   => ['Antapani Tengah', 'Antapani Kidul', 'Antapani Wetan', 'Cisaranten Bina Harapan'],
            'Ujungberung' => ['Pasanggrahan', 'Pasirjati', 'Cigending'],
        ];

        for ($i = 0; $i < 12; $i++) {
            $kec = $faker->randomElement(array_keys($kecamatan));

            Location::create([
                'nama_lokasi' => $faker->randomElement(['TPS', 'Saluran Air', 'Lahan Kosong', 'Taman', 'Pasar']) . ' ' . $faker->streetName(),
                'alamat'      => $faker->streetAddress(),
                // Kisaran koordinat wilayah Bandung timur
                'latitude'    => $faker->randomFloat(8, -6.9400, -6.9000),
                'longitude'   => $faker->randomFloat(8, 107.6500, 107.7000),
                'kecamatan'   => $kec,
                'kelurahan'   => $faker->randomElement($kecamatan[$kec]),
            ]);
        }
    }
}
