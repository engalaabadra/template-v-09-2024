<?php
namespace App\Models\Traits\User;
use App\Models\Traits\User\GeneralUserTrait;
use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
use App\Traits\GeneralTrait;

trait UserMethods{
    use GeneralTrait,GeneralUserTrait;
    /**
    * Method for get Relations  User.
    *
    * @return object
    */
    public function getRelationsUser($model,$userId,$relation){
        $user=$this->find($userId,$model);
        if(is_string($user)){
            return $user;
        }
        if($relation=='roles'){
            return $user->roles()->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->paginate(total());
        }elseif($relation=='permissions'){
            return $user->permissions()->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->paginate(total());
        }

       }



}
