<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LipaNaMpesaController;

Route::prefix('payments')->group(function () {
    Route::get('/', [LipaNaMpesaController::class, 'index'])->name('payments.index');
    Route::post('/initiate-payment', [LipaNaMpesaController::class, 'initiatePayment'])->name('payments.initiate-payment');
    Route::post('/callback', [LipaNaMpesaController::class, 'handleCallback'])->name('payments.callback');
});
