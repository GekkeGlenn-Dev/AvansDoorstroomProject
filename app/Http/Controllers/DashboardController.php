<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\DashboardService;
use Carbon\CarbonPeriod;
use Inertia\Response;

class DashboardController extends Controller
{
    private DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function dashboard(): Response
    {
        $whereDate = now()->subDays(30);
        $orders = Order::with('products')->whereDate('created_at', '>', $whereDate)->get();
        $period = CarbonPeriod::create($whereDate->format('d-m-Y'), now()->format('d-m-Y'))->toArray();

        $revenueAndSalesTotals = $this->dashboardService->generateRevenueAndSalesOverviewTotals($orders);

        return $this->renderVue('Dashboard/Dashboard', [
            'orderSeries' => $this->dashboardService->getChartSeries($period, $orders),
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
