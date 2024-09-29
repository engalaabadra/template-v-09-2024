<?php
namespace Modules\Notification\Entities\Traits;
use App\Models\User;
use App\Models\File;
trait NotificationRelations{
    
    public function file(){
        return $this->morphOne(File::class, 'fileable');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
