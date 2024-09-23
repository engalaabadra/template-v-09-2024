<?php
namespace Modules\Chat\Entities\Traits;
use App\Models\File;
use App\Models\User;

trait ChatRelations{
    public function file(){
        return $this->morphOne(File::class, 'fileable');
    }
    
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function client(){
        return $this->belongsTo(User::class,'client_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }



}
