<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\CatalogSectionController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['web']], function () {
    Route::post('/language/{code}', function (Request $request, Response $response, string $code) {
        return json_encode(['echo' => $code]);
    });

    Route::post('/catalog/fetch/', [CatalogSectionController::class, 'fetch']);
    Route::post('/catalog/{code}', [CatalogSectionController::class, 'page']);
    Route::get('/catalog/checkout/{id}', [CatalogSectionController::class, 'getTourInfo']);
    Route::post('/basket/add/tour', [BasketController::class, 'addTour']);
    Route::post('/checkout/confirm', [\App\Http\Controllers\OrderController::class, 'register']);
    Route::post('/modal/create/{code}', [\App\Http\Controllers\ModalController::class, 'create']);
    Route::get('/calendar/{tour}/{month}/', [\App\Http\Controllers\CalendarController::class, 'month']);
    Route::post('/blog', [\App\Http\Controllers\BlogController::class, 'page']);

    Route::post('/discuss/confirm', function () {
        return ['done' => true];
    });
});

Route::post('/payment/stripe', [PaymentController::class, 'stripeCreate']);
Route::any('/payments/info', [PaymentController::class, 'stripeSuccess']);

