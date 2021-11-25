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
        if ($request->has('query')) {
            Inertia::share('query', $request->get('query'));
        } else {
            Inertia::share('query', $this->shopService->getQuery());
        }

        $sort = $request->has('sort') ? $request->get('sort')['id'] : null;
        $currentSort = $this->shopService->getCurrentProductSortingFromSortId($sort);
        Inertia::share('shop', [
            'sortOptions' => $this->shopService->getProductSortingArray($currentSort['id']),
        ]);
//        dd(Inertia::getShared('query'));


        $products = Product::all();

        return $this->inertia->render('Shop', [
            'products' => $products->toArray(),
        ]);
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
