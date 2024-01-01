<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Monires\MonerisController;
use App\Http\Controllers\Monires\PurchaseController;
use App\Http\Controllers\Monires\PreAuthorization;
use App\Http\Controllers\Monires\CustomerController;
use App\Http\Controllers\Monires\RefundController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/purchase', function () {
    return view('welcome');
});

Route::get('/purchase', function () {
    return view('welcome');
});

Route::post('/purchase', [PurchaseController::class, 'webPurchase'])->name('purchase');
Route::post('/add-card', [MonerisController::class, 'addCard'])->name('add-card');
Route::post('/customer/store', [CustomerController::class, 'store'])->name('add-customer');
Route::post('/pre-authorization', [PreAuthorization::class, 'authorization'])->name('pre-authorization');
Route::post('/refund', [RefundController::class, 'refund'])->name('refund');
