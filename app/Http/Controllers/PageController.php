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
    public function shop(Request $request): Response
    {
        Inertia::share('shop', [
            'sortOptions' => $this->shopService->getProductSorting(),
            'filterOptions' => $this->shopService->getShopFilters()
        ]);


        return $this->inertia->render('Shop');
    }

    /**
     * TODO Add filters to session, misschien dit ook doen voor sort?
     *
     * @param Request $request
     */
    public function addShopFiltersToSession(Request $request)
    {
//        $request->session()->put('filters', ['filter', 'filter2']);
        dd($request->session()->all());
    }
}
