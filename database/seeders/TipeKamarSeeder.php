<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipeKamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run(): void
        {
            $types = [
            ['nama_tipe_kamar' => 'Standard',  'deskripsi_kamar' => 'Kamar standar nyaman', 'harga_per_malam' => 350000, 'kapasitas' => 2],
            ['nama_tipe_kamar' => 'Deluxe',    'deskripsi_kamar' => 'Kamar deluxe dengan view', 'harga_per_malam' => 550000, 'kapasitas' => 2],
            ['nama_tipe_kamar' => 'Suite',     'deskripsi_kamar' => 'Kamar suite mewah', 'harga_per_malam' => 1200000, 'kapasitas' => 4],
            ['nama_tipe_kamar' => 'Family',    'deskripsi_kamar' => 'Kamar keluarga luas', 'harga_per_malam' => 850000, 'kapasitas' => 6],
        ];

        foreach ($types as $type) {
            \App\Models\TipeKamar::create($type);
        }
    }
}
