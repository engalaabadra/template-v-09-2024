<?php
namespace App\Models\Traits\Role;
use App\Models\Traits\Role\RoleAttributes;
use App\Models\Traits\Role\RoleMethods;
use App\Models\Traits\Role\RoleRelations;
use App\Models\Traits\Role\RoleScopes;

trait GeneralRoleTrait{
    use RoleAttributes;
    use RoleMethods;
    use RoleRelations;
    use RoleScopes;

}
