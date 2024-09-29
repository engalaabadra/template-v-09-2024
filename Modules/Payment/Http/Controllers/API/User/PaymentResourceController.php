<?php

namespace Modules\Payment\Http\Controllers\API\User;
use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Repositories\User\Resources\PaymentRepository;
use Modules\Payment\Resources\User\PaymentResource;

class PaymentResourceController extends Controller
{
    use GeneralTrait;
    /**
     * @var PaymentRepository
     */
    protected $paymentRepo;
    /**
     * @var Payment
     */
    protected $payment;
    
    /**
     * PaymentResourceController constructor.
     *
     * @param PaymentRepository $payments
     */
    public function __construct( Payment $payment,PaymentRepository $paymentRepo)
    {
        $this->payment = $payment;
        $this->paymentRepo = $paymentRepo;
    }

    /**
     * Store the  resource in storage.
     * @param Request $request 
     * @return Responsable
     * */
    public function store(){//store meth in payment controller for user as callback meth->store payment proccess for this user
        $payment=$this->paymentRepo->callback();
        return successResponse(1,new PaymentResource($payment));
    }


}
