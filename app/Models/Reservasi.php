<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasis';

    protected $fillable = [
        'user_id',
        'dokter_id',
        'tanggal_reservasi',
        'jam_reservasi',
        'keluhan',
        'status',
        'catatan_dokter',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'tanggal_reservasi' => 'date',
    ];

    // Status reservasi
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    public static function getStatusOptions()
    {
        return [
            self::STATUS_PENDING => 'Menunggu Konfirmasi',
            self::STATUS_CONFIRMED => 'Dikonfirmasi',
            self::STATUS_COMPLETED => 'Selesai',
            self::STATUS_CANCELLED => 'Dibatalkan'
        ];
    }

    public function getStatusLabelAttribute()
    {
        $statuses = self::getStatusOptions();
        return $statuses[$this->status] ?? 'Unknown';
    }

    public function getStatusBadgeClassAttribute()
    {
        switch ($this->status) {
            case self::STATUS_PENDING:
                return 'bg-warning';
            case self::STATUS_CONFIRMED:
                return 'bg-success';
            case self::STATUS_COMPLETED:
                return 'bg-info';
            case self::STATUS_CANCELLED:
                return 'bg-danger';
            default:
                return 'bg-secondary';
        }
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function rekamMedis(): HasOne
    {
        return $this->hasOne(RekamMedis::class);
    }

    // Scopes
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('tanggal_reservasi', '>=', now()->toDateString())
                    ->where('status', '!=', self::STATUS_CANCELLED);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }
}