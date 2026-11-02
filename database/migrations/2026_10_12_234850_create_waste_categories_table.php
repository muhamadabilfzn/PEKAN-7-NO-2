<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kategori jenis sampah yang dilaporkan.
     */
    public function up(): void
    {
        Schema::create('waste_categories', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            $table->text('deskripsi')->nullable();
            $table->string('icon', 100)->nullable()->default('fa-trash');
            $table->string('warna', 10)->nullable()->default('#6c757d');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waste_categories');
    }
};
