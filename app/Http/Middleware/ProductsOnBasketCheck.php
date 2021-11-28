<?php

namespace App\Http\Middleware;

use App\Services\BasketService;
use Closure;
use Illuminate\Http\Request;
use Redirect;

class ProductsOnBasketCheck
{
    private BasketService $basketService;

    public function __construct(BasketService $basketService)
    {
        $this->basketService = $basketService;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param BasketService $basketService
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $basket = $this->basketService->getBasket($request);

        if ($basket->products->count() > 0) {
            return $next($request);
        }

        return Redirect::route('basket');
    }
}
