<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MonerisController;
use App\Http\Controllers\Monires\PreAuthorization;
use App\Http\Controllers\Monires\CustomerController;
use App\Http\Controllers\Monires\RefundController;
use App\Http\Controllers\Monires\PurchaseController;
use App\Http\Controllers\Monires\CardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/add-card', [MonerisController::class, 'addCard']);
Route::post('/purchase', [PurchaseController::class, 'purchase']);
Route::get('/customer/profile/{key?}', [CustomerController::class, 'show']);
Route::post('/customer/store', [CustomerController::class, 'store']);
Route::post('/customer/update/{key?}', [CustomerController::class, 'update']);
Route::post('/pre-authorization', [PreAuthorization::class, 'authorization']);
Route::post('/refund', [RefundController::class, 'refund']);


Route::post('/card/update', [CardController::class, 'update']);
Route::post('/card/destroy', [CardController::class, 'destroy']);