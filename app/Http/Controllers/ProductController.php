<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(): Response
    {
        return $this->inertia->render('Dashboard/Products/Index', [
            'products' => Product::withCount('orders')->paginate(25),
        ]);
    }

    public function create(): Response
    {
       return $this->inertia->render('Dashboard/Products/Create', [
           'categories' => ProductCategory::all()->toArray(),
       ]);
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

        $product->categories()->sync($validated['categories']);

        return \response()->redirectToRoute('dashboard.product.edit', compact('product'));
    }

    public function show(Product $product): Response
    {
        $product->loadMissing('categories', 'images');
        return $this->inertia->render('Products/Show', compact('product'));
    }

    public function edit(Product $product): Response
    {
        $product->loadMissing('categories', 'images')->loadCount('orders');

        return $this->inertia->render('Dashboard/Products/Edit', compact('product'));
    }

    public function update(ProductUpdateRequest $request, Product $product): RedirectResponse
    {
        //todo Make updateRequest, validate, add validated to product, save and redirect to detail page.
        $validated = $request->validated();

        $product->title = $validated['title'];
        $product->slug = Str::slug(trim($validated['title']));
        $product->description = $validated['description'];
        $product->price = $validated['price'] * 100;
        $product->stock = $validated['stock'];
        $product->save();

        return \response()->redirectToRoute('dashboard.product.edit', compact('product'))->with('success', 'Product opgeslagen');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return \response()->redirectToRoute('dashboard.product.index')->with('success', 'Product verwijderd!');
    }
}
