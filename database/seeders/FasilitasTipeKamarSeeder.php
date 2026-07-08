<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipeKamar;

class FasilitasTipeKamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipeKamar::find(1)->fasilitas()->sync([1, 2]);
        TipeKamar::find(2)->fasilitas()->sync([1, 2, 3]);
        TipeKamar::find(3)->fasilitas()->sync([1, 2, 3, 4, 5]);
        TipeKamar::find(4)->fasilitas()->sync([1, 2, 3]);
    }
}
