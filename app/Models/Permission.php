<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;
use GeneralTrait;
class Permission extends LaratrustPermission
{
    use GeneralTrait;
    protected $appends = ['original_active'];
    public $guarded = [];
}
