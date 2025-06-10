<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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