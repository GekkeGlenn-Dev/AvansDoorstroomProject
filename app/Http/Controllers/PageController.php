<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Services\ShopService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class PageController extends Controller
{
    public function shop(): Response
    {
        $this->inertia->share('shop', [
            'sortOptions' => $this->shopService->getProductSorting(),
            'filterOptions' => $this->shopService->getShopFilters()
        ]);


        return $this->inertia->render('Shop');
    }
}
