<?php

use App\Http\Controllers\CatalogSectionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\MainpageController::class, 'show'])->name('mainpage');
Route::get('/tour/{tour}/', [\App\Http\Controllers\TourController::class, 'detail']);
Route::get('/checkout/', [\App\Http\Controllers\CheckoutController::class, 'show']);
Route::get('/blog/', [\App\Http\Controllers\BlogController::class, 'list']);
Route::get('/blog/{code}', [\App\Http\Controllers\BlogController::class, 'detail']);


Route::get('/test/', function(\Illuminate\Http\Request $request) {

    echo '<pre>';
    $calendar = new \App\Travel\Timeslot\Calendar(\App\Models\Tours::find(1));
    $result = $calendar->calculateForCurrentMonth();

    print_r($result);die;

});
