<?php


namespace App\Services;

use App\Models\Basket;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;

class BasketService
{
    public function getBasket(Request $request): Basket
    {
        /** @var Basket $basket */
        if (!Auth::check()) {
            $basket = Basket::with('products')->where('ip', '=', $request->ip())->whereNull('user_id')->firstOrCreate([
                'ip' => $request->ip(),
            ]);

        } else {
            $basket = $request->user()->basket;
            if ($basket === null) {
                $basket = $request->user()->basket()->create([
                    'ip' => $request->ip(),
                ]);
            }
            $basket->loadMissing('products');
        }
        return $basket;
    }

    public function addProduct(Request $request, Product $product): void
    {
        $basket = $this->getBasket($request);
        $basketProduct = $basket->products()->find($product->id);

        if ($basketProduct === null) {
            $basket->products()->attach($product->id, ['quantity' => 1]);
            $basket->save();
            return;
        }

        $basketProduct->pivot->quantity++;
        $basketProduct->pivot->save();
        $basket->touch();
    }

    public function removeProduct(Request $request, Product $product): void
    {
        $basket = $this->getBasket($request);
        $basketProduct = $basket->products()->find($product->id);

        if ($basketProduct === null) {
            return;
        }

        if ($basketProduct->pivot->quantity < 2) {
            $basket->products()->detach($product->id);
            return;
        }

        $basketProduct->pivot->quantity--;
        $basketProduct->pivot->save();
        $basket->touch();
    }
}
