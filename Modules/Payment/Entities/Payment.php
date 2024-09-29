<?php

namespace Modules\Payment\Entities;

use Modules\Payment\Entities\Traits\GeneralPaymentTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;
use App\Traits\GeneralTrait;

class Payment extends BaseModel
{
    use GeneralTrait,GeneralPaymentTrait ,SoftDeletes;
    protected $appends = ['original_active'];
    public $guarded = [];
    public $eagerLoading = ['file'];

   

}
