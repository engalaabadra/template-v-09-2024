<?php
namespace Modules\Movement\Traits;

use App\Traits\GeneralTrait;
use Modules\Movement\Entities\Movement;

trait MovementTrait{
    use GeneralTrait;

    public function createMovement($model,$price,$id,$nameMovement,$type,$item_id=null){
        
    }
    public  function countMovements($walletId){

        return  Movement::where('wallet_id',$walletId)->count();
    }
}

