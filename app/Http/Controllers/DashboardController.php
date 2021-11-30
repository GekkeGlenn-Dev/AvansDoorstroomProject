<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Inertia\Response;

class DashboardController extends Controller
{
    public function dashboard(Request $request): Response
    {
        $orders = Order::with('products', 'orderStatus')
            ->where('user_id', '=', $request->user()->id)
            ->whereBetween('created_at', [now()->subDays(10), now()])
            ->paginate(10);
        return $this->inertia->render('Dashboard/DashboardCustomer', [
            'orders' => $orders,
        ]);
    }

    public function admin(): Response
    {
        $whereDate = now()->subDays(30);
        $orders = Order::with('products')->where('order_status_id', '=', OrderStatus::ORDER_PAYED)->whereDate('created_at', '>', $whereDate)->get();
        $period = CarbonPeriod::create($whereDate->format('d-m-Y'), now()->format('d-m-Y'))->toArray();

        $revenueAndSalesTotals = $this->dashboardService->generateRevenueAndSalesOverviewTotals($orders);

        return $this->inertia->render('Dashboard/Dashboard', [
            'series' => $this->dashboardService->getChartSeries($period, $orders),
            'topProducts' => Product::withCount('orders')->orderByDesc('orders_count')->take(5)->get(),
            'total' => [
                'users' => User::whereDate('created_at', '>', $whereDate)->count(),
                'orders' => $orders->count(),
                'revenue' => $revenueAndSalesTotals->get('revenue'),
                'sales' => $revenueAndSalesTotals->get('sales')
            ],
        ]);
    }
}
