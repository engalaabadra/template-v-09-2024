<?php
namespace Modules\Order\Repositories\User;

use Modules\Order\Repositories\User\OrderRepositoryInterface;
use App\Repositories\EloquentRepository;
use App\Traits\GeneralTrait;
use Modules\Order\Entities\Traits\GeneralOrderTrait;

class OrderRepository extends EloquentRepository implements OrderRepositoryInterface
{
    use GeneralTrait, GeneralOrderTrait;

    public function store($request,$model,$eagerLoading=null){
        return $this->actionMethod($request, $model, $eagerLoading);

    }
}