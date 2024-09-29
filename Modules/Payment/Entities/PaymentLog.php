<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;
use App\Traits\GeneralTrait;

class PaymentLog extends BaseModel
{
    use GeneralTrait ,SoftDeletes;
    protected $appends = ['original_active'];
    public $guarded = [];

}
