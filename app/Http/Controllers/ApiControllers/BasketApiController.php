<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\BasketService;
use App\Services\DashboardService;
use App\Services\ShopService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\ResponseFactory as InertiaResponseFactory;

class BasketApiController extends Controller
{
    private BasketService $basketService;

    public function __construct(InertiaResponseFactory $inertia, ShopService $shopService, DashboardService $dashboardService, BasketService $basketService)
    {
        parent::__construct($inertia, $shopService, $dashboardService);
        $this->basketService = $basketService;
    }

    public function index(Request $request): JsonResponse
    {
        $basket = $this->basketService->getBasket($request);
        return response()->json($basket);
    }
}
