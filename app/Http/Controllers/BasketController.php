<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\BasketService;
use App\Services\DashboardService;
use App\Services\ShopService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use Inertia\ResponseFactory as InertiaResponseFactory;

class BasketController extends Controller
{
    private BasketService $basketService;

    public function __construct(
        InertiaResponseFactory $inertia,
        ShopService $shopService,
        DashboardService $dashboardService,
        BasketService $basketService
    ) {
        parent::__construct($inertia, $shopService, $dashboardService);
        $this->basketService = $basketService;
    }

    public function index(Request $request): Response
    {
        $basket = $this->basketService->getBasket($request);
        return $this->inertia->render('Basket', [
            'basket' => $basket
        ]);
    }

    public function addProduct(Request $request, Product $product): RedirectResponse
    {
        $this->basketService->addProduct($request, $product);
        return Redirect::back()->with('basket_notification', sprintf('Product %s is toegevoegd aan winkelmand.', $product->title));
    }

    public function removeProduct(Request $request, Product $product): RedirectResponse
    {
        $this->basketService->removeProduct($request, $product);
        return Redirect::back()->with('basket_notification', sprintf('Product %s is verwijderd van winkelmand.', $product->title));
    }

    public function checkoutDetails(Request $request): Response
    {
        return $this->inertia->render('Checkout/Checkout', [
            'basket' => $this->basketService->getBasket($request),
        ]);
    }

    public function checkoutOrderDetails(Order $order): Response
    {
        $order->loadMissing('products');
        return $this->inertia->render('Checkout/CheckoutDetail', [
            'order' => $order
        ]);
    }
}
