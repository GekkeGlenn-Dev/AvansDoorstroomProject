<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\ShopService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Response;

class PageController extends Controller
{
    private ShopService $shopService;

    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    public function shop(Request $request): Response
    {
        $sort = $this->shopService->getProductSortQuery($request->get('sort'));
        $products = Product::with('categories', 'images')->orderBy($sort['column'], $sort['direction'])->get();

//        Cache::forget('product.category.all');
        $categories = Cache::remember('product.category.all', 60 * 60 * 24, function () {
            return ProductCategory::all();
        });

        return $this->renderVue('Shop', [
            'sortOptions' => $this->shopService->getProductSortingArray($request->get('sort')),
            'products' => $products->toArray(),
            'categories' => $categories->toArray(),
            'filters' => $this->shopService->getShopFilters($categories->toArray()),
        ]);
    }

    public function addShopFiltersToSession()
    {
        
    }
}
