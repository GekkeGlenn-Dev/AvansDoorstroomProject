<?php

namespace App\Http\Controllers;

use App\Http\Requests\BasketCheckoutFormRequest;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Services\BasketService;
use App\Services\DashboardService;
use App\Services\ShopService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use Inertia\ResponseFactory as InertiaResponseFactory;

class OrderController extends Controller
{
    private BasketService $basketService;

    public function __construct(
        InertiaResponseFactory $inertia, ShopService $shopService, DashboardService $dashboardService,
        BasketService $basketService
    ) {
        parent::__construct($inertia, $shopService, $dashboardService);
        $this->basketService = $basketService;
    }

    public function index(): Response
    {
        return $this->inertia->render('Dashboard/Orders/Index', [
            'orders' => Order::with('orderStatus', 'user')
                ->withCount('products')
                ->orderBy('created_at', 'desc')
                ->paginate(25),
        ]);
    }

    public function store(BasketCheckoutFormRequest $request): RedirectResponse
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

        foreach ($basket->products as $product) {
            $order->products()->attach($product->id, ['quantity' => $product->pivot->quantity]);
            $basket->products()->detach($product->id);
            $product->save();
        }

        $order->save();
        $basket->save();

        return Redirect::route('basket.checkout.finish', ['order' => $order]);
    }

    public function showAll(Request $request): Response
    {
        $orders = Order::with('products', 'orderStatus')
            ->where('user_id', '=', $request->user()->id)
            ->orderByDesc('id')
            ->paginate(10);

        return $this->inertia->render('Dashboard/Orders/ShowAll', [
            'orders' => $orders,
        ]);
    }

    public function show(Request $request, Order $order)
    {
        $order->loadMissing('products', 'orderStatus');

        return $this->inertia->render('Dashboard/Orders/Show', [
            'order' => $order,
        ]);
    }

    public function edit(Order $order): Response
    {
        $order->loadMissing('orderStatus', 'user', 'products');

        $order->addAddressToCollection();
        $order->created_at_formated = sprintf('%s om %s',
            $order->created_at->format('d M Y'),
            $order->created_at->format('H:i')
        );

        return $this->inertia->render('Dashboard/Orders/Edit', [
            'order' => $order,
        ]);
    }
}
