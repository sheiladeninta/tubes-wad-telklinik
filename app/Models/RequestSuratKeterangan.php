<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestSuratKeterangan extends Model
{
    use HasFactory;

    protected $table = 'request_surat_keterangan';

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'jenis_surat',
        'keperluan',
        'tanggal_mulai_sakit',
        'tanggal_selesai_sakit',
        'keluhan',
        'keterangan_tambahan',
        'status',
        'alasan_ditolak',
        'file_surat',
        'tanggal_request',
        'tanggal_diproses'
    ];

    protected $casts = [
        'tanggal_mulai_sakit' => 'date',
        'tanggal_selesai_sakit' => 'date',
        'tanggal_request' => 'datetime',
        'tanggal_diproses' => 'datetime'
    ];

    // Status constants
    const STATUS_PENDING = 'pending';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DITOLAK = 'ditolak';

    // Jenis surat constants
    const JENIS_SAKIT = 'sakit';
    const JENIS_SEHAT = 'sehat';
    const JENIS_RUJUKAN = 'rujukan';
    const JENIS_KETERANGAN_MEDIS = 'keterangan_medis';

    /**
     * Relasi dengan model User (Pasien)
     */
    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    /**
     * Relasi dengan model User (Dokter)
     */
    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk filter berdasarkan pasien
     */
    public function scopeByPasien($query, $pasienId)
    {
        return $query->where('pasien_id', $pasienId);
    }

    /**
     * Scope untuk filter berdasarkan dokter
     */
    public function scopeByDokter($query, $dokterId)
    {
        return $query->where('dokter_id', $dokterId);
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_DIPROSES => 'info',
            self::STATUS_SELESAI => 'success',
            self::STATUS_DITOLAK => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            self::STATUS_PENDING => 'Menunggu Persetujuan',
            self::STATUS_DIPROSES => 'Sedang Diproses',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DITOLAK => 'Ditolak',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get jenis surat label
     */
    public function getJenisSuratLabelAttribute()
    {
        return match($this->jenis_surat) {
            self::JENIS_SAKIT => 'Surat Keterangan Sakit',
            self::JENIS_SEHAT => 'Surat Keterangan Sehat',
            self::JENIS_RUJUKAN => 'Surat Rujukan',
            self::JENIS_KETERANGAN_MEDIS => 'Surat Keterangan Medis',
            default => 'Tidak Diketahui'
        };
    }

    /**
     * Get durasi sakit dalam hari
     */
    public function getDurasiSakitAttribute()
    {
        if ($this->tanggal_mulai_sakit && $this->tanggal_selesai_sakit) {
            return $this->tanggal_mulai_sakit->diffInDays($this->tanggal_selesai_sakit) + 1;
        }
        return null;
    }
}