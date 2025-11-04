<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\LogController;

Route::get('/logs', [LogController::class, 'index']);
Route::post('/logs', [LogController::class, 'store']);

use App\Http\Controllers\NotificationController;

Route::post('/notify', [NotificationController::class, 'send']);

use App\Http\Controllers\PaymentController;

Route::post('/payments', [PaymentController::class, 'pay']);

use App\Http\Controllers\ExportController;

Route::post('/export', [\App\Http\Controllers\ExportController::class, 'export']);

use App\Http\Controllers\OrderController;

Route::post('/orders/place', [OrderController::class, 'place']);

use App\Http\Controllers\StockController;

Route::post('/stocks/subscribe',   [StockController::class, 'subscribe']);
Route::post('/stocks/unsubscribe', [StockController::class, 'unsubscribe']);
Route::post('/stocks/price',       [StockController::class, 'price']);
Route::get ('/stocks/{symbol}/subs',[StockController::class, 'subscriptions']);

use App\Http\Controllers\DiscountController;

Route::post('/discount', [DiscountController::class, 'calculate']);

use App\Http\Controllers\OrderChainController;

Route::post('/orders/simple-chain', [OrderChainController::class, 'process']);