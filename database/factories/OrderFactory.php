<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random(1)->first()->id,
            'order_status_id' => OrderStatus::all()->random(1)->first()->id,
            'number' => $this->faker->unique()->numerify('####################'),
            'street' => $this->faker->streetName,
            'house_number' => $this->faker->numberBetween(1,145),
            'house_number_addition' => $this->faker->randomLetter,
            'postal_code' => $this->faker->postcode,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'created_at' => $this->faker->dateTimeBetween('-60 days'),
        ];
    }
}
