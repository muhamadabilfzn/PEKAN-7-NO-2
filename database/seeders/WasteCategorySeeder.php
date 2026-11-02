<?php

namespace Database\Seeders;

use App\Models\WasteCategory;
use Illuminate\Database\Seeder;

class WasteCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Data referensi tetap.
        $kategori = [
            ['nama' => 'Plastik/Kering',  'deskripsi' => 'Sampah plastik, botol, dan anorganik kering',    'icon' => 'fa-wine-bottle',       'warna' => '#00bcd4'],
            ['nama' => 'Organik/Basah',   'deskripsi' => 'Sampah organik, sisa makanan, dan daun',         'icon' => 'fa-leaf',              'warna' => '#28a745'],
            ['nama' => 'Bangunan Liar',   'deskripsi' => 'Puing bangunan, material konstruksi, besi tua',  'icon' => 'fa-hard-hat',          'warna' => '#ffc107'],
            ['nama' => 'B3 / Berbahaya',  'deskripsi' => 'Baterai, elektronik bekas, obat kadaluarsa',     'icon' => 'fa-skull-crossbones',  'warna' => '#dc3545'],
            ['nama' => 'Campuran',        'deskripsi' => 'Sampah campur yang belum dipilah',               'icon' => 'fa-dumpster',          'warna' => '#6c757d'],
        ];

        foreach ($kategori as $row) {
            WasteCategory::create($row);
        }
    }
}
