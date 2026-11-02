<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Penugasan petugas untuk menangani laporan. Relasi: waste_reports, officers, users (admin)
     */
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('waste_reports')->cascadeOnDelete();
            $table->foreignId('officer_id')->constrained('officers');
            $table->foreignId('assigned_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('catatan')->nullable();
            $table->enum('status', ['pending', 'diterima', 'selesai'])->default('pending');
            $table->timestamp('assigned_at')->useCurrent();
            $table->timestamp('selesai_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
