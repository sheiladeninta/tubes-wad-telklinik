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
        Schema::create('request_surat_keterangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('dokter_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('jenis_surat', ['sakit', 'sehat', 'rujukan', 'keterangan_medis']);
            $table->string('keperluan');
            $table->date('tanggal_mulai_sakit')->nullable();
            $table->date('tanggal_selesai_sakit')->nullable();
            $table->text('keluhan')->nullable();
            $table->text('keterangan_tambahan')->nullable();
            $table->enum('status', ['pending', 'diproses', 'selesai', 'ditolak'])->default('pending');
            $table->text('alasan_ditolak')->nullable();
            $table->string('file_surat')->nullable();
            $table->timestamp('tanggal_request');
            $table->timestamp('tanggal_diproses')->nullable();
            $table->timestamps();

            // Index untuk optimasi query
            $table->index(['pasien_id', 'status']);
            $table->index(['dokter_id', 'status']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_surat_keterangan');
    }
};