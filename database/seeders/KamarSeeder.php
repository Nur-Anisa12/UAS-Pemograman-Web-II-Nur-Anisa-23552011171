<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
        ['tipe_kamar_id' => 1, 'nomor_kamar' => '101', 'status' => 'tersedia', 'deskripsi' => 'Kamar standar nyaman'],
        ['tipe_kamar_id' => 1, 'nomor_kamar' => '102', 'status' => 'tersedia', 'deskripsi' => 'Kamar standar nyaman'],
        ['tipe_kamar_id' => 2, 'nomor_kamar' => '201', 'status' => 'tersedia', 'deskripsi' => 'Kamar deluxe dengan view'],
        ['tipe_kamar_id' => 2, 'nomor_kamar' => '202', 'status' => 'tersedia', 'deskripsi' => 'Kamar deluxe dengan view'],
        ['tipe_kamar_id' => 3, 'nomor_kamar' => '301', 'status' => 'tersedia', 'deskripsi' => 'Kamar suite mewah'],
        ['tipe_kamar_id' => 4, 'nomor_kamar' => '401', 'status' => 'tersedia', 'deskripsi' => 'Kamar keluarga luas'],
    ];

    foreach ($rooms as $room) {
        \App\Models\Kamar::create($room);
    }
    }
}
