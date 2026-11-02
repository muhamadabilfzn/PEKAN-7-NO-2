<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $faker   = FakerFactory::create('id_ID');
        $adminId = User::where('role_id', 1)->value('id');

        $judul = [
            ['Cara Memilah Sampah dengan Benar',               'pemilahan'],
            ['5 Kreasi Daur Ulang Botol Plastik',              'daur_ulang'],
            ['Jadwal Pengangkutan Sampah Terbaru',             'kebersihan'],
            ['Mengolah Sampah Organik Menjadi Kompos',         'pengelolaan'],
            ['Mengenal Sampah B3 di Lingkungan Rumah',         'pemilahan'],
            ['Manfaat Bank Sampah bagi Warga',                 'pengelolaan'],
            ['Tips Menjaga Selokan Tetap Bersih',              'kebersihan'],
            ['Kreasi Tas Belanja dari Kain Perca',             'daur_ulang'],
            ['Mengurangi Sampah Plastik Sekali Pakai',         'pemilahan'],
            ['Gotong Royong Membersihkan Lingkungan RW',       'kebersihan'],
        ];

        foreach ($judul as [$j, $kategori]) {
            Article::create([
                'user_id'      => $adminId,
                'judul'        => $j,
                'slug'         => Article::buatSlug($j),
                'thumbnail'    => null,
                'konten'       => implode("\n\n", $faker->paragraphs(3)),
                'kategori'     => $kategori,
                'is_published' => $faker->boolean(85),
            ]);
        }
    }
}
