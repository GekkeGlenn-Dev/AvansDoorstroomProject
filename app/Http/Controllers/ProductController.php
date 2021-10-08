<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;
use App\Services\ShopService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    private ShopService $shopService;

    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }

    public function index(): Response
    {
        return Inertia::render('Dashboard/Products/Index', [
            'products' => Product::withCount('orders')->paginate(25),
        ]);
    }

    public function create(): Response
    {
       return $this->renderVue('Dashboard/Products/Create');
    }

    public function store(ProductStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $product = new Product();
        $product->title = $validated['title'];
        $product->slug = Str::slug(trim($validated['title']));
        $product->description = $validated['description'];
        $product->price = $validated['price'] * 100;
        $product->stock = $validated['stock'];
        $product->save();

        return \response()->redirectToRoute('dashboard.product.edit', ['product' => $product]);
        //todo add images and categories.
    }

    public function show(Product $product): Response
    {
        $product->loadMissing('categories', 'images');
        return $this->renderVue('Products/Show', compact('product'));
    }

    public function edit(Product $product): Response
    {
        $product->loadMissing('categories', 'images')->loadCount('orders');

        return $this->renderVue('Dashboard/Products/Edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }

    public function ApiQuery(Request $request): string
    {
        if (!$request->has('query')) {
            $query = $this->shopService->getQuery();
        } else {
            $query = $request->get('query');
        }
        if (!is_array($query)) {
            return 'is not array';
        }

        if (!key_exists('sorts', $query) || !key_exists('filters', $query)) {
            return '';
        }

        return $this->shopService->executeProductQuery($query, true);
    }
}
