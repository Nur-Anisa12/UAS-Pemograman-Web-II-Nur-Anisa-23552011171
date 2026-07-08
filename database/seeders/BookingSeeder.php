<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Tamu;
Use App\Models\Kamar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Generate 20 booking acak pakai Factory
        Booking::factory(20)->create();

    }
}
