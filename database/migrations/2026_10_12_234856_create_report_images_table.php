<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Foto/video bukti laporan. Relasi: waste_reports
     */
    public function up(): void
    {
        Schema::create('report_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('waste_reports')->cascadeOnDelete();
            $table->string('file_path');
            $table->enum('file_type', ['foto', 'video'])->default('foto');
            $table->boolean('is_bukti_selesai')->default(false);
            $table->timestamp('uploaded_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_images');
    }
};
