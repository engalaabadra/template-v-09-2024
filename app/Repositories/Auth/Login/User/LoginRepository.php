<?php
namespace App\Repositories\Auth\Login\User;

use App\Repositories\EloquentRepository;

class LoginRepository extends EloquentRepository implements LoginRepositoryInterface{
    /** Login
     * @param LoginRequest $request
     * @param User $model
     * @return object
     */
    public function login($request,$model){
        $user = $request->checkLogin($request);
        if(is_string($user)) return $user;
        if(!$user || !$user->roles->contains('name','user')) return trans('messages.Invalid credentials');
        return $user;
    }
    /** Logout
     * @param Request $request
     * @return object
     */
    public function logout($request){
        if(!hasRole(authUser(),'user')) return trans('messages.Invalid credentials');
        $request->user()->token()->revoke();
        return true;
    }
}
