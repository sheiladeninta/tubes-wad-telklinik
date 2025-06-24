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
        Schema::create('obat', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat');
            $table->enum('jenis_obat', [
                'tablet', 
                'kapsul', 
                'sirup', 
                'injeksi', 
                'salep', 
                'tetes', 
                'spray', 
                'suppositoria', 
                'lainnya'
            ]);
            $table->text('deskripsi')->nullable();
            $table->text('komposisi')->nullable();
            $table->string('dosis')->nullable();
            $table->text('cara_pakai')->nullable();
            $table->text('efek_samping')->nullable();
            $table->text('kontraindikasi')->nullable();
            $table->integer('stok')->default(0);
            $table->decimal('harga', 10, 2)->default(0);
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->string('nomor_batch')->nullable();
            $table->string('pabrik')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->string('gambar')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('nama_obat');
            $table->index('jenis_obat');
            $table->index('status');
            $table->index('tanggal_kadaluarsa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat');
    }
};