<?php

namespace App\Http\Controllers;

use App\Models\Basket;

class CheckoutController extends Controller
{
    public function show() {
        $basket = BasketController::getSessionBasketItems();

        if(!$basket || !count($basket->items)) {
            return redirect()->route('mainpage');
        }

        $passengers = [];
        $basketModel = Basket::loadBasket();
        $basketItem = $basketModel->items()->where('is_tour', true)->first();
        $isBokun = false;
        if ($basketItem) {
            $properties = BasketController::getProperties($basketItem);
            $isBokun = !empty($properties['bokun_id']);
            $pricing = json_decode($properties['bokun_pricing'] ?? '[]', true) ?: [];
            foreach ($pricing as $categoryId => $quantity) {
                for ($i = 0; $i < $quantity; $i++) {
                    $passengers[] = ['pricing_category_id' => (int) $categoryId];
                }
            }
        }

        return view('page.checkout', [
            'checkout' => (object)[
                'basket' => $basket,
                'passengers' => $passengers,
                'is_bokun' => $isBokun,
            ]
        ]);
    }
}
