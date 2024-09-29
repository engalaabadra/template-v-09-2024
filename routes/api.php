<?php
/**************************Auth************************************* */
use App\Http\Controllers\API\Auth\RecoveryPasswordController;
use App\Http\Controllers\API\Auth\User\LoginController;
use App\Http\Controllers\API\Auth\User\RegisterController;
use App\Http\Controllers\API\FileController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\HomeController;
use App\Mail\General;
use Illuminate\Http\Request;



Route::post('email',function(Request $request){
    if($request['type']=='welcome' || $request['type']=='check-code' || $request['type']=='new-reservation' || $request['type']=='cancel-reservation' || $request['type']=='reminder-reservation' || $request['type']=='rescheduling-reservation'){
      Mail::to($request['email'])->send(new General($request));  
      return 'done';
    } 
    return ;
});

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::prefix('register')->group(function(){
    Route::post('/', [RegisterController::class, 'register'])->name('register');
    //opertaions reg, login
    Route::post('/check-code', [RegisterController::class, 'checkCodeRegister'])->name('check-code-register');
    Route::get('/resend-code', [RegisterController::class, 'resendCodeRegister'])->name('resend-code-register');
});


Route::prefix('recovery-by-password')->group(function(){
    Route::post('forgot-password',  [RecoveryPasswordController::class,'forgotPassword'])->name('forgot-password');
    //opertaions recovery-by-password
    Route::post('check-code', [RecoveryPasswordController::class,'checkCodeRecovery'])->name('check-code-pass');
    Route::get('resend-code', [RecoveryPasswordController::class,'resendCodeRecovery'])->name('resend-code-pass');
    Route::post('reset-password', [RecoveryPasswordController::class,'resetPassword'])->name('reset-password');
});


//logout
Route::middleware(['auth:api'])->group(function(){
    Route::delete('/logout', [LoginController::class, 'destroy']);
});
//file
Route::post('/upload-files/{modelName}/{id}',[FileController::class,'storeFiles'])->name('file.store-files');

//home
Route::get('/home',[HomeController::class,'index'])->name('home.all');
//Lang
Route::get('lang/{lang}', ['as' => 'lang.switch.api', 'uses' => 'App\Http\Controllers\API\LanguageController@switchLang']);
Route::get('get-all-langs', ['as' => 'lang.langs.api', 'uses' => 'App\Http\Controllers\API\LanguageController@getAllLangs']);
Route::get('default-lang', ['as' => 'lang.default-lang.api', 'uses' => 'App\Http\Controllers\API\LanguageController@defaultLang']);

//additional
