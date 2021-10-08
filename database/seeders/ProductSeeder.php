<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::factory(150)->create();

        foreach ($products as $product) {
            $categorieIds = ProductCategory::all()->random(rand(1, 3))->pluck('id')->toArray();
            $product->categories()->attach($categorieIds);
        }
    }
}
