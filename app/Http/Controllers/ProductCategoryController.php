<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryStoreRequest;
use App\Http\Requests\ProductCategoryUpdateRequest;
use App\Models\ProductCategory;
use App\Services\DashboardService;
use App\Services\ProductCategoryService;
use App\Services\ShopService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory as InertiaResponseFactory;
use Str;

class ProductCategoryController extends Controller
{
    private ProductCategoryService $productCategoryService;

    public function __construct(InertiaResponseFactory $inertia, ShopService $shopService, DashboardService $dashboardService, ProductCategoryService $productCategoryService)
    {
        parent::__construct($inertia, $shopService, $dashboardService);
        $this->productCategoryService = $productCategoryService;
    }

    public function index(Request $request): Response
    {
        $categories = $this->productCategoryService->allPaginate();

        return $this->inertia->render('Dashboard/Products/categories/Index', [
            'categories' => $categories,
            'could_not_delete' => $request->get('could_not_delete'),
        ]);
    }

    public function store(ProductCategoryStoreRequest $request): RedirectResponse
    {
        $this->productCategoryService->create($request->validated());
        return redirect()->route('dashboard.product.category.index');
    }

    public function update(ProductCategoryUpdateRequest $request, ProductCategory $productCategory): RedirectResponse
    {
        $this->productCategoryService->save($productCategory, $request->validated());
        return redirect()->route('dashboard.product.category.index');
    }

    public function destroy(ProductCategory $productCategory): RedirectResponse
    {
        try {
            $this->productCategoryService->delete($productCategory);
            return redirect()->route('dashboard.product.category.index');
        } catch (Exception $e) {
            return redirect()->back()->with('could_not_delete', 'Categorie heeft producten gekoppeld.');
        }
    }
}
