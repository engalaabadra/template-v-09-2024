<?php

use App\Http\Controllers\WEB\ContactUsController;
use App\Http\Controllers\WEB\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TwitterController;
use App\Http\Controllers\WEB\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Broadcast;

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/register',[RegisterController::class,'create'] )->name('register-form');
Route::post('/register',[RegisterController::class,'store'] )->name('website-register');
Route::get('/success/{type}',function ($type) {
    if ($type == 0) {
        return view('pages.static.patient-success-page');
    }
    return view('pages.static.doctor-success-page');
});

Route::post('/contact-us',[ContactUsController::class,'store'] )->name('website-contact-us');


Route::get('/policy', function () {
    return view('pages.static.ar.policy');
})->name('policy');

Route::get('/about', function () {
    return view('pages.static.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.static.contact');
})->name('contact');


Route::get('/notfound', function () {
    return view('pages.static.notfound');
})->name('notfound');


Broadcast::routes();


//Clear Cache facade value:
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Reoptimized class loader:
Route::get('/optimize-clear', function() {
    Artisan::call('optimize:clear');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
//Clear Config clear:
Route::get('/config-clear', function() {
    Artisan::call('config:clear');
    return '<h1>Clear Config cleared</h1>';
});
//migrate:
Route::get('/migrate', function() {
    Artisan::call('migrate');
    return '<h1>Clear Config cleared</h1>';
});
//migrate-fresh:
Route::get('/migrate-fresh', function() {
    Artisan::call('migrate:fresh');
    return '<h1>Clear Config cleared</h1>';
});

//Passport install
Route::get('/passport-install', function() {
    Artisan::call('passport:install');
    return '<h1>passport install</h1>';
});

//storage link
Route::get('/storage-link', function() {
    Artisan::call('storage:link');
    return '<h1>storage link</h1>';
});



Route::get('auth/twitter', [TwitterController::class, 'loginwithTwitter']);
Route::get('auth/callback/twitter', [TwitterController::class, 'cbTwitter']);

//Lang
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\WEB\LanguageController@switchLang']);
Route::get('get-all-langs', ['as' => 'lang.langs', 'uses' => 'App\Http\Controllers\WEB\LanguageController@getAllLangs']);
Route::get('default-lang', ['as' => 'lang.default-lang', 'uses' => 'App\Http\Controllers\WEB\LanguageController@defaultLang']);


//additional
Route::get('/changeNames', function() {
    $arr = [];
    $files = \Storage::disk('public')->files("chats-files/thumbnail");
    foreach($files as $file)
    if (str_contains($file,"(L)")) {
        $variable = substr($file, 0, strpos($file, "(L)"));
        $str = str_replace("(L)", "", $file, $count);
        $str = str_replace("chats-files/thumbnail", "", $str, $count);
        // dd("chats-files" . $str);
        \Storage::disk('public')->move($file,"chats-files" . $str);
    }

});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
