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
        Schema::create('detail_resep_obat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resep_obat_id')->constrained('resep_obat')->onDelete('cascade');
            $table->string('nama_obat');
            $table->string('dosis');
            $table->integer('jumlah');
            $table->string('satuan');
            $table->text('aturan_pakai');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index(['resep_obat_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_resep_obat');
    }
};