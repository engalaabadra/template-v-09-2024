<?php
namespace App\Repositories\Auth\Register\User;

use App\Models\Traits\User\GeneralUserTrait;
use App\Traits\GeneralTrait;

class RegisterRepository implements RegisterRepositoryInterface{
    use GeneralTrait,GeneralUserTrait;
    /** Register
     * @param RegitserRequest $request
     * @return object
     */
    public function register($request,$model){//model2:registerCodeNum
        $resultReg = $request->actionRegister($request,$model);
        if(is_string($resultReg)) return $resultReg;
        session(['info_user'=>(object)$resultReg]);
        return $resultReg;
    }
}
