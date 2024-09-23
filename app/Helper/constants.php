<?php
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Carbon\Carbon;

 function dashboard(){
   return 'admin.dashboard';
 }
 function home(){
    return 'home';
 }
 function localLang(){
   return config('app.locale');
 }
 function strRandom(){
   return mt_rand(1000, 9999);
}
function strLength($data){
   return Str::length($data);
}
function hashData($data){
   return Hash::make($data);
}
function hashCheck($value1,$value2){
   return Hash::check($value1, $value2);
}
function exceptData($data,$dataExcept){
   return Arr::except($data ,$dataExcept);
}

function urlFlag($code){
   return 'https://ipdata.co/flags/'.$code.'.png';
}
function systemCurrency(){
   return 'SAR';
}
function tapId(){
   return request()->input('tap_id');
}
function isEagerLoading(){
   return request()->input('is_eager_loading');
}
function location(){
   return geoip(request()->ip());
}
function countryCurrency(){
   return  location()->currency;
}
//for filters

function lang(){
   if(isset(getallheaders()['lang'])) return getallheaders()['lang']  ? getallheaders()['lang'] : localLang();
   else return localLang();
}
function my(){
   return request()->input('my');
}
function page(){
   return request()->input('page');
}

function postId(){
   return request()->input('post_id');
}
function clientId(){
   return request()->input('client_id');
}
function isAnonymous(){
   return request()->input('is_anonymous');
}

function sessionId(){
   return request()->input('session_id');
}

function status(){
   return request()->input('status');
}

function message(){
   return request()->input('message');
}

//for filter 
function rate(){
   return request()->input('rate');
}

function fav(){
   return request()->input('fav');
}


function search(){
   return request()->input('search');
}

function type(){
   return request()->input('type');
}


function randomLink(){
   return request()->input('link');
}

function getTokenPayment($paymentMethod){
   if($paymentMethod == 'moyasar') $token=base64_encode(config("services.moyasar.key_live"));
   if($paymentMethod == 'tap') $token=base64_encode(config("services.tap.key_live"));
   return $token;
}

function isSoftDeletes($model){
   return in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($model));
}

function currentTime(){
   $currentDateTime = Carbon::now();
   $currentTime = $currentDateTime->toTimeString();
   return $currentTime;
}
function currentDate(){
   $currentDateTime = Carbon::now();
   $currentDate = $currentDateTime->toDateString();
   return $currentDate;
}

function modelName($model){
   return strtolower(class_basename($model)) . 's';
}

function getModelClass($modelName){
   $namespace = 'Modules\\'. ucfirst($modelName). '\\Entities\\';
   $modelClass = $namespace . $modelName;
   //check if exist this model or not
   return class_exists($modelClass) ? $modelClass : null;
}

function total(){
   return request()->get('total', 10);
}
/**
 * Generate a code based on the application environment.
 *
 * @return string
 */
function getCode(): string
{
    return appProduction() ? strRandom() : '0000';
}

/**
 * Check if the application is in production environment.
 *
 * @return bool
 */
function appProduction(): bool
{
    return env('APP_ENV') === 'production';
}

function filePath($url){
   return 'public/' . ltrim($url, '/storage/');
}