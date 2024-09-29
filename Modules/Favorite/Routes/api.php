<?php

use Illuminate\Support\Facades\Route;
use Modules\Favorite\Http\Controllers\API\User\FavoriteResourceController;

Route::resource('favorites', FavoriteResourceController::class)->only(['index','store','destroy']);
//another routes for module Favorites
Route::prefix('favorites')->as('favorites')->group(function(){
    //routes  additional for module Favorites
    Route::as('additional')->group(function(){

    });
});
