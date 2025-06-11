<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResepObat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'resep_obat';

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'reservasi_id',
        'nomor_resep',
        'tanggal_resep',
        'diagnosa',
        'catatan_dokter',
        'status',
        'tanggal_ambil',
        'farmasi_id'
    ];

    protected $casts = [
        'tanggal_resep' => 'date',
        'tanggal_ambil' => 'date'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_DIPROSES = 'diproses';
    const STATUS_SIAP = 'siap';
    const STATUS_DIAMBIL = 'diambil';
    const STATUS_EXPIRED = 'expired';

    public static function getStatusOptions()
    {
        return [
            self::STATUS_PENDING => 'Menunggu Persetujuan',
            self::STATUS_DIPROSES => 'Sedang Diproses',
            self::STATUS_SIAP => 'Siap Diambil',
            self::STATUS_DIAMBIL => 'Sudah Diambil',
            self::STATUS_EXPIRED => 'Kedaluwarsa'
        ];
    }

    public function getStatusLabelAttribute()
    {
        $statuses = self::getStatusOptions();
        return $statuses[$this->status] ?? 'Tidak Diketahui';
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            self::STATUS_PENDING => 'warning',
            self::STATUS_DIPROSES => 'info',
            self::STATUS_SIAP => 'success',
            self::STATUS_DIAMBIL => 'secondary',
            self::STATUS_EXPIRED => 'danger'
        ];
        return $colors[$this->status] ?? 'dark';
    }

    // Relationships
    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class);
    }

    public function farmasi()
    {
        return $this->belongsTo(User::class, 'farmasi_id');
    }

    public function detailResep()
    {
        return $this->hasMany(DetailResepObat::class, 'resep_obat_id');
    }

    // Scopes
    public function scopeByPasien($query, $pasienId)
    {
        return $query->where('pasien_id', $pasienId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', [
            self::STATUS_PENDING, 
            self::STATUS_DIPROSES, 
            self::STATUS_SIAP
        ]);
    }

    // Methods
    public function generateNomorResep()
    {
        $date = now()->format('Ymd');
        $count = self::whereDate('created_at', now())->count() + 1;
        return 'RSP-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function isExpired()
    {
        if ($this->status === self::STATUS_SIAP) {
            // Resep expired setelah 30 hari dari tanggal resep
            return $this->tanggal_resep->addDays(30)->isPast();
        }
        return false;
    }

    public function canBePickedUp()
    {
        return $this->status === self::STATUS_SIAP && !$this->isExpired();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($resep) {
            if (empty($resep->nomor_resep)) {
                $resep->nomor_resep = $resep->generateNomorResep();
            }
            if (empty($resep->tanggal_resep)) {
                $resep->tanggal_resep = now();
            }
        });
    }
}