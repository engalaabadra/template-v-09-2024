<?php

namespace Modules\Profile\Entities;

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Profile\Entities\Traits\GeneralProfileTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
class Profile extends Model
{
    use GeneralProfileTrait,SoftDeletes;
    protected $appends = ['original_gender'];

    public $fillable = ['full_name','nick_name','user_id','bio','gender','birth_date'];

    public $eagerLoading = ['user'];
    public function user() { 
        return $this->belongsTo(User::class); 
    }
    public function file(){
        return $this->morphOne(File::class, 'fileable');
    }
    
}
