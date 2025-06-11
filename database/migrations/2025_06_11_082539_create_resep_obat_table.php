<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resep_obat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('reservasi_id')->nullable()->constrained('reservasis')->onDelete('set null');
            $table->string('nomor_resep')->unique();
            $table->date('tanggal_resep');
            $table->text('diagnosa');
            $table->text('catatan_dokter')->nullable();
            $table->enum('status', ['pending', 'diproses', 'siap', 'diambil', 'expired'])->default('pending');
            $table->date('tanggal_ambil')->nullable();
            $table->foreignId('farmasi_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['pasien_id', 'status']);
            $table->index(['tanggal_resep']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resep_obat');
    }
};