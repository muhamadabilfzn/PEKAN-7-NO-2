<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabel ini dipakai halaman Bantuan tetapi tidak ada di dump cleanhub_db.sql.
 * Tabel lain (users, waste_reports, dst.) dibuat dari database/sql/cleanhub_db.sql.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('support_messages')) {
            return;
        }

        Schema::create('support_messages', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('email', 100);
            $table->string('subjek', 150)->nullable();
            $table->text('pesan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_messages');
    }
};
