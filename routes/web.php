<?php

use App\Http\Controllers\CheckoutController;
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

Route::get('/', function () {
    return view('Page.Home', ['title' => 'Home']);
});

Route::get('/cart', function () {
    return view('Page.Cart', ['title' => 'cart']);
});
Route::get('/checkout', function () {
    return view('Page.Checkout', ['title' => 'checkout']);
});
Route::get('/checkout/success/{id}',[CheckoutController::class,'success'])->name('success');
Route::get('/payment', function () {
    return view('Page.payment', ['title' => 'Payment']);
});
Route::get('/checkout/p/{ts_number}', function ($ts_number) {
    return view('Page.Checkout',['ts_number' => $ts_number]);
});
