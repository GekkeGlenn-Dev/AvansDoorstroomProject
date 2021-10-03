<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ProductCategorySeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
//            UserSeeder::class
        ]);
    }
}
