<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Artikel edukasi. Relasi: users (penulis)
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('judul', 200);
            $table->string('slug', 200)->unique();
            $table->string('thumbnail')->nullable();
            $table->longText('konten');
            $table->enum('kategori', ['pemilahan', 'daur_ulang', 'kebersihan', 'pengelolaan']);
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
