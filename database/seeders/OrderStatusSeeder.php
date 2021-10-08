<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::factory()->create([
            'name' => 'Betaling in afwachting'
        ]);

        OrderStatus::factory()->create([
            'name' => 'Betaling geannuleerd'
        ]);

        OrderStatus::factory()->create([
            'name' => 'Betaling mislukt'
        ]);

        OrderStatus::factory()->create([
            'name' => 'Betaald'
        ]);

        OrderStatus::factory()->create([
            'name' => 'Onderweg'
        ]);

        OrderStatus::factory()->create([
            'name' => 'Niet geleverd'
        ]);

        OrderStatus::factory()->create([
            'name' => 'Afgeleverd bij ophaal punt'
        ]);

        OrderStatus::factory()->create([
            'name' => 'Bezorgd'
        ]);
    }
}
