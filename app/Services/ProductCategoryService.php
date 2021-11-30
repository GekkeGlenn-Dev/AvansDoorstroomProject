<?php


namespace App\Services;

use App\Models\ProductCategory;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ProductCategoryService
{
    private const CACHE_KEY = 'product.category.all';

    public function all()
    {
        return Cache::remember(self::CACHE_KEY, 60 * 60 * 24, function () {
            return ProductCategory::query()->withCount('products')->get();
        });
    }

    public function allPaginate($route = 'dashboard.product.category.index'): LengthAwarePaginator
    {
        $categories = $this->all();
        $page = LengthAwarePaginator::resolveCurrentPage();

        return new LengthAwarePaginator($categories, $categories->count(), 15, $page, [
            'path' => route($route)
        ]);
    }

    public function create(array $validated)
    {
        $category = new ProductCategory();
        $category->name = $validated['name'];
        $category->slug = Str::slug($validated['name']);
        $category->save();

        Cache::forget(self::CACHE_KEY);
    }

    public function save(ProductCategory $productCategory, array $validated)
    {
        $productCategory->name = $validated['name'];
        $productCategory->slug = Str::slug($validated['name']);
        $productCategory->save();

        Cache::forget(self::CACHE_KEY);
    }

    /**
     * @throws Exception
     */
    public function delete(ProductCategory $productCategory)
    {
        if ($productCategory->products()->count() > 0) {
            throw new Exception('Category has more than one product');
        }
        $productCategory->delete();
        Cache::forget(self::CACHE_KEY);
    }
}
