<?php
namespace App\Repositories\Auth\Login\Admin;

use App\Repositories\EloquentRepository;

class LoginRepository extends EloquentRepository implements LoginRepositoryInterface{
    public function login($request,$model){
        $resultLogin = $request->checkLogin($request);
        if(is_string($resultLogin)) return $resultLogin;
        $roles= $resultLogin->roles->pluck('name')->toArray();
        if(!in_array('admin',$roles)) return trans('messages.Invalid credentials');
        return $resultLogin;
    }

    public function logout($request){
        $roles= authUser()->roles->pluck('name')->toArray();
        if(!in_array('admin',$roles)) return trans('messages.Invalid credentials');
        $request->user()->token()->revoke();
        return true;
    }
}
