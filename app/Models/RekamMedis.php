<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';

    protected $fillable = [
        'user_id',
        'dokter_id',
        'reservasi_id',
        'tanggal_pemeriksaan',
        'keluhan',
        'diagnosa',
        'tindakan',
        'resep_obat',
        'catatan_dokter',
        'tinggi_badan',
        'berat_badan',
        'tekanan_darah',
        'suhu_tubuh',
        'nadi',
        'status'
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'datetime',
        'tinggi_badan' => 'decimal:2',
        'berat_badan' => 'decimal:2',
        'suhu_tubuh' => 'decimal:1',
        'nadi' => 'integer'
    ];

    // Relasi ke User (Pasien)
    public function pasien(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke User (Dokter)
    public function dokter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    // Relasi ke Reservasi
    public function reservasi(): BelongsTo
    {
        return $this->belongsTo(Reservasi::class);
    }

    // Accessor untuk BMI
    public function getBmiAttribute()
    {
        if ($this->tinggi_badan && $this->berat_badan) {
            $tinggi_meter = $this->tinggi_badan / 100;
            return round($this->berat_badan / ($tinggi_meter * $tinggi_meter), 2);
        }
        return null;
    }

    // Accessor untuk kategori BMI
    public function getKategoriBmiAttribute()
    {
        $bmi = $this->bmi;
        if (!$bmi) return null;

        if ($bmi < 18.5) return 'Kurus';
        if ($bmi < 25) return 'Normal';
        if ($bmi < 30) return 'Gemuk';
        return 'Obesitas';
    }

    // Scope untuk filter berdasarkan pasien
    public function scopeForPasien($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal_pemeriksaan', [$startDate, $endDate]);
    }
}