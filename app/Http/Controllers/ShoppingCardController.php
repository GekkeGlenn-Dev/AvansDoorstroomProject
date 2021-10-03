<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Response;

class ShoppingCardController extends Controller
{
    public function addProduct(Request $request): RedirectResponse
    {
        $product = $request->get('product');

        $shoppingCardSession = $request->session()->get('shoppingCard', []);
        foreach ($shoppingCardSession as $item) {
            if ($item['id'] === $product->id) {
                $item['quantity'] += $product['quantity'];
            } else {
                array_push($shoppingCardSession, $product);
            }
        }

        return redirect()->back()->with('succes', 'Product ' . $product->title . ' is toegevoegd aan je winkelmandje');
    }
}
