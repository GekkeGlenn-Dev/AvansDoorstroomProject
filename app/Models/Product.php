<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    public function categories(): BelongsToMany
    {
        return $this->BelongsToMany(ProductCategory::class, 'product_product_category', 'product_id', 'product_category_id');
    }

    public function orders(): BelongsToMany
    {
        return $this->BelongsToMany(Order::class)
            ->withPivot('quantity');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }
}
