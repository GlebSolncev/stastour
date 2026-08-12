<?php

namespace App\Http\Controllers\Tour;

use App\Services\Bokun\BokunBookingService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ShoppingCartTourController
{

    public function __invoke(Request $request, BokunBookingService $apiService)
    {
        $validated = $request->validate([
            'tour_id' => ['required', 'integer'],
            'date' => ['required', 'date_format:Y-m-d'],
            'start_time_id' => ['required'],
            'pricing' => ['required', 'array', 'min:1'],
            'pricing.*' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $pricings = [];
        foreach ($validated['pricing'] as $id => $quantity) {
            for ($i = 0; $i < $quantity; $i++) {
                $pricings[] = [
                    'pricingCategoryId' => $id,
                ];
            }
        }

        $singleStartId = !is_array($validated['start_time_id']);
        $startIds = array_map('intval', (array) $validated['start_time_id']);
        [$data, $error] = $apiService->shoppingCart(
            (int) $validated['tour_id'],
            $validated['date'],
            $startIds,
            $pricings
        );


        if ($singleStartId) {
            abort_unless(isset($data[0]), 422, 'The selected time is no longer available.');
            $data = $data[0];
        }

        $items = [];

        foreach (Arr::get($data, 'options.0.invoice.productInvoices', []) as $prod) {
            foreach ($prod['lineItems'] as $item) {
                $items[] = [
                    'title' => $item['title'],
                    'quantity' => $item['quantity'],
                    'unitPrice' => $item['unitPrice'],
                    'total' => $item['total'],
                    'unitPriceAsText' => $item['unitPriceAsText'],
                    'totalAsText' => $item['totalAsText'],
                ];
            }
        }

        return response()->json([
            'sessionId' => Arr::get($data, 'sessionId'),
            'totalPrice' => Arr::get($data, 'options.0.amount'),
            'totalDueAsText' => Arr::get($data, 'options.0.formattedAmount'),
            'items' => $items,
            'errors' => $error
        ]);
    }
}
