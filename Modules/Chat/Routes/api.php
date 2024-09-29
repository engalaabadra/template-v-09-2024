<?php

use Illuminate\Support\Facades\Route;
use Modules\Chat\Http\Controllers\API\User\ChatResourceController;
use Modules\Chat\Http\Controllers\API\User\ChatController;


Route::resource('chats', ChatResourceController::class)->only(['index','store','update','destroy']);
Route::prefix('chats')->group(function(){
    Route::post('store-files/{id}', [ChatController::class,'storeFiles']);
});

Route::delete('chats', [ChatResourceController::class,'deleteAll']);
