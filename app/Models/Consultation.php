<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'subject',
        'description',
        'status',
        'priority',
        'started_at',
        'completed_at',
        'consultation_fee'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'consultation_fee' => 'decimal:2'
    ];

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(ConsultationMessage::class);
    }

    public function latestMessage(): HasMany
    {
        return $this->hasMany(ConsultationMessage::class)->latest();
    }

    public function unreadMessages(): HasMany
    {
        return $this->hasMany(ConsultationMessage::class)->where('is_read', false);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'waiting' => '<span class="badge bg-warning">Menunggu</span>',
            'active' => '<span class="badge bg-success">Aktif</span>',
            'completed' => '<span class="badge bg-primary">Selesai</span>',
            'cancelled' => '<span class="badge bg-danger">Dibatalkan</span>',
            default => '<span class="badge bg-secondary">Unknown</span>'
        };
    }

    public function getPriorityBadgeAttribute(): string
    {
        return match($this->priority) {
            'low' => '<span class="badge bg-light text-dark">Rendah</span>',
            'normal' => '<span class="badge bg-info">Normal</span>',
            'high' => '<span class="badge bg-warning">Tinggi</span>',
            'urgent' => '<span class="badge bg-danger">Mendesak</span>',
            default => '<span class="badge bg-secondary">Unknown</span>'
        };
    }

    public function scopeForPasien($query, $pasienId)
    {
        return $query->where('pasien_id', $pasienId);
    }

    public function scopeForDokter($query, $dokterId)
    {
        return $query->where('dokter_id', $dokterId);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeWaiting($query)
    {
        return $query->where('status', 'waiting');
    }
}