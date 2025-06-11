<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailResepObat extends Model
{
    use HasFactory;

    protected $table = 'detail_resep_obat';

    protected $fillable = [
        'resep_obat_id',
        'nama_obat',
        'dosis',
        'jumlah',
        'satuan',
        'aturan_pakai',
        'keterangan'
    ];

    // Relationships
    public function resepObat()
    {
        return $this->belongsTo(ResepObat::class, 'resep_obat_id');
    }

    // Accessors
    public function getFormattedDosisAttribute()
    {
        return $this->dosis . ' ' . $this->satuan;
    }

    public function getFormattedJumlahAttribute()
    {
        return $this->jumlah . ' ' . $this->satuan;
    }
}