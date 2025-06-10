<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dokters = [
            [
                'name' => 'Dr. Ahmad Fauzi, Sp.PD',
                'email' => 'dr.ahmad@tel-klinik.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
                'user_type' => 'dokter',
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No. 123, Bandung',
                'birth_date' => '1980-05-15',
                'gender' => 'L',
                'blood_type' => 'A',
                'allergies' => null,
                'medical_history' => null,
                'specialist' => 'Penyakit Dalam',
                'license_number' => 'STR-001-2020',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Siti Nurhaliza, Sp.A',
                'email' => 'dr.siti@tel-klinik.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
                'user_type' => 'dokter',
                'phone' => '081234567891',
                'address' => 'Jl. Sudirman No. 456, Bandung',
                'birth_date' => '1985-08-22',
                'gender' => 'P',
                'blood_type' => 'B',
                'allergies' => null,
                'medical_history' => null,
                'specialist' => 'Anak',
                'license_number' => 'STR-002-2021',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Budi Santoso, Sp.OG',
                'email' => 'dr.budi@tel-klinik.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
                'user_type' => 'dokter',
                'phone' => '081234567892',
                'address' => 'Jl. Asia-Afrika No. 789, Bandung',
                'birth_date' => '1978-12-10',
                'gender' => 'L',
                'blood_type' => 'O',
                'allergies' => null,
                'medical_history' => null,
                'specialist' => 'Obstetri dan Ginekologi',
                'license_number' => 'STR-003-2019',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Maya Sari, Sp.JP',
                'email' => 'dr.maya@tel-klinik.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
                'user_type' => 'dokter',
                'phone' => '081234567893',
                'address' => 'Jl. Braga No. 321, Bandung',
                'birth_date' => '1982-03-28',
                'gender' => 'P',
                'blood_type' => 'AB',
                'allergies' => null,
                'medical_history' => null,
                'specialist' => 'Jantung dan Pembuluh Darah',
                'license_number' => 'STR-004-2022',
                'is_active' => true,
            ],
            [
                'name' => 'Dr. Rizki Pratama, Sp.M',
                'email' => 'dr.rizki@tel-klinik.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
                'user_type' => 'dokter',
                'phone' => '081234567894',
                'address' => 'Jl. Dago No. 654, Bandung',
                'birth_date' => '1987-11-05',
                'gender' => 'L',
                'blood_type' => 'A',
                'allergies' => null,
                'medical_history' => null,
                'specialist' => 'Mata',
                'license_number' => 'STR-005-2023',
                'is_active' => true,
            ]
        ];

        foreach ($dokters as $dokter) {
            User::create($dokter);
        }

        $this->command->info('Dokter seeder completed successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Email: dr.ahmad@tel-klinik.com | Password: password123');
        $this->command->info('Email: dr.siti@tel-klinik.com | Password: password123');
        $this->command->info('Email: dr.budi@tel-klinik.com | Password: password123');
        $this->command->info('Email: dr.maya@tel-klinik.com | Password: password123');
        $this->command->info('Email: dr.rizki@tel-klinik.com | Password: password123');
    }
}