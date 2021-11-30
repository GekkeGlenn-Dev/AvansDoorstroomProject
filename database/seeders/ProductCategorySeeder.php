<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Str;

class ProductCategorySeeder extends Seeder
{
    private array $categories = [];

    public function run()
    {
        $this->createCategory('Computers');
        $this->createCategory('Katten speeltjes');
        $this->createCategory('Meubels');
        $this->createCategory('Games');
        $this->createCategory('Verkoeling');
        $this->createCategory('Overig');

        ProductCategory::query()->insert($this->categories);
    }

    private function createCategory(string $name)
    {
        $this->categories[] = [
            'name' => $name,
            'slug' => Str::slug($name),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
