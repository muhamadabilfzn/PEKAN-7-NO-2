<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Urutan penting: tabel induk harus terisi lebih dulu sebelum tabel yang memakai foreign key.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            WasteCategorySeeder::class,
            LocationSeeder::class,
            UserSeeder::class,
            OfficerSeeder::class,
            WasteReportSeeder::class,
            AssignmentSeeder::class,
            ArticleSeeder::class,
            NotificationSeeder::class,
            ActivityLogSeeder::class,
            SupportMessageSeeder::class,
        ]);
    }
}
