<?php
namespace Modules\Review\Entities\Traits;
use App\Models\User;
use Modules\Reservation\Entities\Reservation;
trait ReviewRelations{
    
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
