<?php
namespace App\Models\Traits\User;
use App\Models\Traits\User\UserAttributes;
use App\Models\Traits\User\UserMethods;
use App\Models\Traits\User\UserRelations;
use App\Models\Traits\User\UserScopes;

trait GeneralUserTrait{
    use UserAttributes;
    // use UserMethods;
    use UserRelations;
    use UserScopes;

}
