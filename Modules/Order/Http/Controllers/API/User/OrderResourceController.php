<?php

namespace Modules\Order\Http\Controllers\API\User;
use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use Modules\Order\Repositories\User\OrderRepository;

class OrderResourceController extends Controller
{
    use GeneralTrait;
    /**
     * @var OrderRepository
     */
    protected $orderRepo;
        /**
     * @var Order
     */
    protected $order;
    
    /**
     * OrderController constructor.
     *
     * @param OrderRepository $orders
     */
    public function __construct( Order $order,OrderRepository $orderRepo)
    {
        $this->order = $order;
        $this->orderRepo = $orderRepo;
    }

    /**
     * Store the  resource in storage.
     * @param Request $request 
     * @return Responsable
     * */
    public function store(StoreOrderRequest $request){
        $order=$this->orderRepo->store($request,$this->order,$this->order->eagerLoading);
        return successResponse(1,new OrderResource($order));
    }    


}
