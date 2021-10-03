<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard/Products/Index', [
            'products' => Product::withCount('orders')->paginate(25),
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

    public function show(Product $product): Response
    {
        $product->loadMissing('categories', 'images');
        return $this->renderVue('Products/Show', compact('product'));
    }

    public function edit(Product $product): Response
    {
        $product->loadMissing('categories', 'images');
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
}
