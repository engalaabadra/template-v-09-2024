<?php
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Storage;
use Modules\Geocode\Entities\Country;
use Illuminate\Support\Str;


function getToken(){
    $allHeaders=getallheaders();
    if(isset($allHeaders['Authorization'])){
        $tokenHeader=substr($allHeaders['Authorization'],7);
        return $tokenHeader;

    }else{
        return 401;
    }
}

function authUser(){
    return auth()->guard('api')->user();
}

function createToken($user){
    return $user->createToken('token')->accessToken;
}

function fullNumber($phone,$countryId)
{
    $PhoneCode = Country::whereId($countryId)->value('phone_code');
    $number = ltrim($PhoneCode, '+') . $phone;
    return $number;

}
function randomSession(){
    return Str::random(30);
}
function sessionUser(){
    return Storage::get('session_id');
}
function putSessionUser(){
    if(sessionUser()) Storage::put('session_id',sessionUser());
    else  Storage::put('session_id',randomSession());
    return sessionUser();
}


function hasRole($person, $nameRole){
    if($person->roles->contains('name',$nameRole)) return true;
}
