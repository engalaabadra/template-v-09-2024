<?php

namespace Modules\Chat\Entities;

use App\Traits\GeneralTrait;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Chat\Entities\Traits\GeneralChatTrait;

class Chat extends Model
{
    use GeneralTrait,GeneralChatTrait,SoftDeletes;
    protected $appends = ['original_active'];
    public $guarded = [];
    public $eagerLoading = ['files','client','user'];

}
