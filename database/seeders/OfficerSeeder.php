<?php

namespace Database\Seeders;

use App\Models\Officer;
use App\Models\User;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class OfficerSeeder extends Seeder
{
    public function run(): void
    {
        $faker = FakerFactory::create('id_ID');

        // Setiap user ber-role petugas (role_id = 2) mendapat satu profil petugas.
        foreach (User::where('role_id', 2)->get() as $user) {
            Officer::create([
                'user_id'    => $user->id,
                'area_kerja' => $faker->randomElement(['Arcamanik', 'Antapani', 'Ujungberung']) . ' – ' .
                                $faker->randomElement(['Cisaranten Endah', 'Cisaranten Kidul', 'Antapani Tengah', 'Pasanggrahan']),
                'saldo'      => $faker->numberBetween(0, 20) * 7500,
                'status'     => $user->status,
            ]);
        }
    }
}
