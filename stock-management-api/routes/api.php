<?php
use App\Http\Controllers\ItemController;
use App\Http\Controllers\StockTransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware('api_key')->group(function () {
    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/items/{id}', [ItemController::class, 'show']);
    Route::post('/items', [ItemController::class, 'store']);
    Route::put('/items/{id}', [ItemController::class, 'update']);
    Route::delete('/items/{id}', [ItemController::class, 'destroy']);
    Route::post('/transactions', [StockTransactionController::class, 'store']);
    Route::get('/transactions', [StockTransactionController::class, 'index']);
    Route::get('/stock-report', [StockTransactionController::class, 'stockReport']);
});