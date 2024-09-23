<?php
use Modules\Profile\Http\Controllers\API\User\ProfileController;

Route::prefix('profile')->as('profile.')->group(function(){
    Route::get('/', [ProfileController::class,'show'])->name('show');
    Route::put('/', [ProfileController::class,'update'])->name('update');
    Route::put('update-password', [ProfileController::class,'updatePassword'])->name('update-password');
});

