<?php

namespace Modules\Board\Entities;

use App\Traits\GeneralTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Board\Entities\Traits\GeneralBoardTrait;

class Board extends Model
{
    use GeneralTrait,GeneralBoardTrait,SoftDeletes;
    protected $appends = ['original_active'];
    public $guarded = [];
    public $eagerLoading = ['file'];

}

