<?php

namespace Database\Seeders;

use App\Models\Tamu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TamuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Data tamu manual (spesifik)
        Tamu::create([
            'nama_lengkap' => 'Budi Santoso',
            'identity_number' => '3201234567890001',
            'no_telepon'     => '08123456789',
            'alamat'   => 'Jl. Merdeka No.5, Bandung',
        ]);

        Tamu::create([
            'nama_lengkap' => 'Sari Dewi',
            'identity_number' => '3201234567890002',
            'no_telepon'     => '08987654321',
            'alamat'   => 'Jl. Sudirman No.10, Jakarta',
        ]);

        // Tambah 18 tamu acak pakai Factory (total jadi 20 tamu)
        // Tamu::factory(18)->create();
    }
}
