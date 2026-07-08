<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Tamu;
use App\Models\Kamar;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $checkIn  = fake()->dateTimeBetween('-3 months', 'now');
        $checkOut = fake()->dateTimeBetween($checkIn, '+7 days');
        $nights   = $checkIn->diff($checkOut)->days ?: 1;

        $room       = Kamar::inRandomOrder()->first();
        $pricePerNight = $room->tipeKamar->harga_per_malam;

        return [
            'tamu_id'       => Tamu::inRandomOrder()->first()->id,
            'kamar_id'        => $room->id,
            // 'handled_by'     => null,
            'check_in_date'  => $checkIn->format('Y-m-d'),
            'check_out_date' => $checkOut->format('Y-m-d'),
            'total_malam'   => $nights,
            'total_harga'    => $nights * $pricePerNight,
            'status'         => fake()->randomElement([
                'pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled'
            ]),
            'catatan'          => fake()->optional()->sentence(),
        ];
    }
}
