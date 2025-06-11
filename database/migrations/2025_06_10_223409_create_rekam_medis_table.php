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
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pasien
            $table->foreignId('dokter_id')->constrained('users')->onDelete('cascade'); // Dokter
            $table->foreignId('reservasi_id')->nullable()->constrained()->onDelete('set null');
            $table->datetime('tanggal_pemeriksaan');
            $table->text('keluhan');
            $table->text('diagnosa');
            $table->text('tindakan')->nullable();
            $table->text('resep_obat')->nullable();
            $table->text('catatan_dokter')->nullable();
            
            // Vital Signs
            $table->decimal('tinggi_badan', 5, 2)->nullable(); // dalam cm
            $table->decimal('berat_badan', 5, 2)->nullable(); // dalam kg
            $table->string('tekanan_darah')->nullable(); // format: 120/80
            $table->decimal('suhu_tubuh', 4, 1)->nullable(); // dalam celsius
            $table->integer('nadi')->nullable(); // dalam bpm
            
            $table->enum('status', ['draft', 'final'])->default('final');
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('dokter_id');
            $table->index('tanggal_pemeriksaan');
            $table->index(['user_id', 'tanggal_pemeriksaan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};