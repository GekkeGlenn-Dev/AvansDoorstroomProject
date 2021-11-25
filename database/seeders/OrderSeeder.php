<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = Order::all();

        foreach ($orders as $order) {
            $productIds = Product::all()->random(rand(2, 5))->pluck('id')->toArray();

            $order->products()->attach($productIds, ['quantity' => rand(1, 3)]);
        }
    }
}
