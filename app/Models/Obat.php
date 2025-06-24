<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Obat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'obat';

    protected $fillable = [
        'nama_obat',
        'jenis_obat',
        'deskripsi',
        'komposisi',
        'dosis',
        'cara_pakai',
        'efek_samping',
        'kontraindikasi',
        'stok',
        'harga',
        'tanggal_kadaluarsa',
        'nomor_batch',
        'pabrik',
        'status',
        'gambar'
    ];

    protected $casts = [
        'tanggal_kadaluarsa' => 'date',
        'harga' => 'decimal:2',
        'stok' => 'integer'
    ];

    protected $dates = ['deleted_at'];

    // Scope untuk status aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    // Scope untuk stok menipis (kurang dari 10)
    public function scopeStokMenupis($query)
    {
        return $query->where('stok', '<', 10);
    }

    // Scope untuk obat hampir kadaluarsa (kurang dari 6 bulan)
    public function scopeHampirKadaluarsa($query)
    {
        return $query->where('tanggal_kadaluarsa', '<=', now()->addMonths(6));
    }

    // Accessor untuk format harga
    public function getHargaFormatAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    // Accessor untuk status stok
    public function getStatusStokAttribute()
    {
        if ($this->stok == 0) {
            return 'Habis';
        } elseif ($this->stok < 10) {
            return 'Menipis';
        } elseif ($this->stok < 50) {
            return 'Sedang';
        } else {
            return 'Aman';
        }
    }

    // Accessor untuk badge class status stok
    public function getStatusStokBadgeAttribute()
    {
        switch ($this->status_stok) {
            case 'Habis':
                return 'badge-danger';
            case 'Menipis':
                return 'badge-warning';
            case 'Sedang':
                return 'badge-info';
            case 'Aman':
                return 'badge-success';
            default:
                return 'badge-secondary';
        }
    }

    // Method untuk check apakah obat hampir kadaluarsa
    public function isHampirKadaluarsa()
    {
        return $this->tanggal_kadaluarsa <= now()->addMonths(6);
    }

    // Method untuk check apakah obat sudah kadaluarsa
    public function isKadaluarsa()
    {
        return $this->tanggal_kadaluarsa < now();
    }
}