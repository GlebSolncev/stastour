<?php

namespace App\Http\Controllers;

class CheckoutController extends Controller
{
    public function show() {
        $basket = BasketController::getSessionBasketItems();

        if(!$basket || !count($basket->items)) {
            return redirect()->route('mainpage');
        }

        return view('page.checkout', [
            'checkout' => (object)[
                'basket' => $basket
            ]
        ]);
    }
}
