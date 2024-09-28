<?php
namespace App\Models\Traits\Role;

use App\Scopes\ActiveScope;
use App\Scopes\LanguageScope;
use App\Traits\GeneralTrait;

trait RoleMethods{
    use GeneralTrait;

    /**
    * Method for get Relations  Role.
    *
    * @return object
    */    
    public function getRelationsRole($model,$roleId,$relation){
        $role=$this->find($roleId,$model);
        if(is_string($role)){
            return $role;
        }
        if($relation=='users'){
            return $role->users()->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->paginate(total());
    }elseif($relation=='permissions'){
            return $role->permissions()->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->paginate(total());
        }
        
    }


}
