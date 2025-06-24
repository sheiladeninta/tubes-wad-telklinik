<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'user_type',
        'phone',
        'address',
        'birth_date',
        'gender',
        'blood_type',
        'allergies',
        'medical_history',
        'specialist',
        'license_number',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Relasi untuk reservasi sebagai pasien
    public function reservasi(): HasMany
    {
        return $this->hasMany(Reservasi::class, 'user_id');
    }

    // Relasi untuk reservasi sebagai dokter
    public function reservasiDokter(): HasMany
    {
        return $this->hasMany(Reservasi::class, 'dokter_id');
    }

    // Relasi untuk rekam medis sebagai pasien
    public function rekamMedis(): HasMany
    {
        return $this->hasMany(RekamMedis::class, 'user_id');
    }

    // Relasi untuk rekam medis sebagai dokter
    public function rekamMedisDokter(): HasMany
    {
        return $this->hasMany(RekamMedis::class, 'dokter_id');
    }

    // Relasi untuk resep obat sebagai pasien
    public function resepObat(): HasMany
    {
        return $this->hasMany(ResepObat::class, 'pasien_id');
    }

    // Relasi untuk resep obat sebagai dokter
    public function resepObatDokter(): HasMany
    {
        return $this->hasMany(ResepObat::class, 'dokter_id');
    }

    // Scope untuk role
    public function scopePasien($query)
    {
        return $query->where('role', 'pasien');
    }

    public function scopeDokter($query)
    {
        return $query->where('role', 'dokter');
    }

    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    // Helper methods
    public function isPasien()
    {
        return $this->role === 'pasien';
    }

    public function isDokter()
    {
        return $this->role === 'dokter';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function getFullNameAttribute()
    {
        return $this->name;
    }

    public function getRoleDisplayAttribute()
    {
        $roles = [
            'pasien' => 'Pasien',
            'dokter' => 'Dokter',
            'admin' => 'Administrator'
        ];
        
        return $roles[$this->role] ?? $this->role;
    }

    public function getUserTypeDisplayAttribute()
    {
        $types = [
            'mahasiswa' => 'Mahasiswa',
            'dosen' => 'Dosen',
            'pegawai' => 'Pegawai',
            'dokter' => 'Dokter',
            'admin' => 'Administrator'
        ];
        
        return $types[$this->user_type] ?? $this->user_type;
    }
}