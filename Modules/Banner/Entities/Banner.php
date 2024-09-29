<?php

namespace Modules\Banner\Entities;

use App\Traits\GeneralTrait;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Banner\Entities\Traits\GeneralBannerTrait;

class Banner extends Model
{
    use GeneralTrait,GeneralBannerTrait,SoftDeletes;
    protected $appends = ['original_active'];
    public $guarded = [];
    public $eagerLoading = ['file'];
}
