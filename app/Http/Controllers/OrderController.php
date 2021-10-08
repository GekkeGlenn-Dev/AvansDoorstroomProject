<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index(): \Inertia\Response
    {
        return $this->renderVue('Dashboard/Orders/Index', [
            'orders' => Order::with('orderStatus', 'user')
                ->withCount('products')
                ->orderBy('created_at', 'desc')
                ->paginate(25),
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Order $order)
    {

    }

    public function edit(Order $order): \Inertia\Response
    {
        $order->loadMissing('orderStatus', 'user', 'products');

        $order->addAddressToCollection();
        $order->created_at_formated = sprintf('%s om %s',
            $order->created_at->format('d M Y'),
            $order->created_at->format('H:i')
        );
//        dd($order);

        return $this->renderVue('Dashboard/Orders/Edit', [
            'order' => $order,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Order $order
     * @return Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
