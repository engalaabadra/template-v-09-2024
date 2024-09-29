<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\API\User\PaymentMethodResourceController;
use Modules\Payment\Http\Controllers\API\User\PaymentResourceController;

Route::any('payment/callback',[PaymentResourceController::class,'callback'])->name('api.payment.callback');


Route::middleware(['auth:api','role:user'])->group(function(){
    Route::resource('payments', PaymentMethodResourceController::class)->only(['index']);
});
