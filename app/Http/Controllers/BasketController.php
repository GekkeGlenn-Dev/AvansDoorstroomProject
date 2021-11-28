<?php

namespace App\Http\Controllers;

use App\Http\Requests\BasketCheckoutFormRequest;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Services\BasketService;
use App\Services\DashboardService;
use App\Services\ShopService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

    // todo pagina met informatie voor order, Met alle details van winkelmand
    public function checkoutDetails(Request $request): Response
    {
        return $this->inertia->render('Checkout/Checkout', [
            'basket' => $this->basketService->getBasket($request),
        ]);
    }

    // todo save informatie naar database en maak een order aan. Redirect naar checkoutOrderDetails
    //  Leeg zijn winkelmand.
    public function processCheckout(BasketCheckoutFormRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $basket = $this->basketService->getBasket($request);

        $order = new Order();
        if (auth()->check()) {
            $order->user()->associate($request->user());
        }

        $order->order_status_id = OrderStatus::ORDER_PAYED;
        $order->number = Carbon::now()->getTimestamp();
        $order->fill($validated);
        $order->save();

        foreach($basket->products as $product) {
            $order->products()->attach($product->id, ['quantity' => $product->pivot->quantity]);
            $product->stock -= $product->pivot->quantity;
            $basket->products()->detach($product->id);
            $product->save();
        }

        $order->save();
        $basket->save();

        return Redirect::route('basket.checkout.finish');
    }

    // todo the order details die net betaald is.
    public function checkoutOrderDetails(Order $order): Response
    {
        $order->loadMissing('products');
        return $this->inertia->render('Checkout/CheckoutDetail', [
            'order' => $order
        ]);
    }
}
