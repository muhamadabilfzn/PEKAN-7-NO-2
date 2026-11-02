<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Laporan sampah dari masyarakat (tabel inti). Relasi: users, waste_categories, locations
     */
    public function up(): void
    {
        Schema::create('waste_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('waste_categories');
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete();
            $table->text('deskripsi');
            $table->enum('status', ['diajukan', 'diverifikasi', 'diproses', 'ditangani', 'selesai'])
                  ->default('diajukan')->index();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('alamat_detail')->nullable();
            $table->decimal('iuran', 10, 2)->default(15000);
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waste_reports');
    }
};
