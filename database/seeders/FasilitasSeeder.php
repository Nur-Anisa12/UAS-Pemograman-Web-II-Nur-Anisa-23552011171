<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FasilitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $facilities = [
        ['nama_fasilitas' => 'Wi-Fi', 'deskripsi_fasilitas' => 'Akses internet nirkabel cepat dan stabil.'],
        ['nama_fasilitas' => 'AC', 'deskripsi_fasilitas' => 'Sistem pendingin udara untuk kenyamanan tamu.'],
        ['nama_fasilitas' => 'TV', 'deskripsi_fasilitas' => 'Televisi layar datar dengan saluran kabel.'],
        ['nama_fasilitas' => 'Kamar Mandi Pribadi', 'deskripsi_fasilitas' => 'Kamar mandi pribadi dengan shower dan perlengkapan mandi.'],
        ['nama_fasilitas' => 'Lemari', 'deskripsi_fasilitas' => 'Lemari untuk menyimpan pakaian dan barang pribadi.'],
        ['nama_fasilitas' => 'Meja Kerja', 'deskripsi_fasilitas' => 'Meja kerja dengan kursi untuk bekerja atau menulis.'],
        ['nama_fasilitas' => 'Mini Bar', 'deskripsi_fasilitas' => 'Mini bar dengan minuman ringan dan camilan.'],
        ['nama_fasilitas' => 'Balkon', 'deskripsi_fasilitas' => 'Balkon pribadi dengan pemandangan luar.'],
        ['nama_fasilitas' => 'Brankas', 'deskripsi_fasilitas' => 'Brankas untuk menyimpan barang berharga.'],
        ['nama_fasilitas' => 'Telepon', 'deskripsi_fasilitas' => 'Telepon untuk melakukan panggilan lokal dan internasional.'],
    ];

    foreach ($facilities as $facility) {
        \App\Models\Fasilitas::create($facility);
    }
}
}
