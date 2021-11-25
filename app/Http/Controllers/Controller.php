<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Services\ShopService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Inertia\ResponseFactory as InertiaResponseFactory;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected InertiaResponseFactory $inertia;
    protected ShopService $shopService;
    protected DashboardService $dashboardService;

    public function __construct(
        InertiaResponseFactory $inertia,
        ShopService $shopService,
        DashboardService $dashboardService
    )
    {
        $this->inertia = $inertia;
        $this->shopService = $shopService;
        $this->dashboardService = $dashboardService;
    }
}
