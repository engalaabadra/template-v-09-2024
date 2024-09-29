<?php
namespace Modules\Payment\Repositories\User\Resources;

use Modules\Payment\Repositories\User\Resources\PaymentMethodRepositoryInterface;
use App\Repositories\EloquentRepository;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Session;
use  Modules\Payment\Entities\PaymentMethod;
use Modules\Payment\Services\PaymentGateways\PaymentGatewayFactory;

class PaymentMethodRepository extends EloquentRepository implements PaymentMethodRepositoryInterface
{
    use GeneralTrait,PaymentMethod;


    public function callback(){
        //will get gateway from payment id in session that put it in create meth 
        $gateway = PaymentMethod::where('id',Session::get('payment_method_id'))->first();
        return $gateway->verify($gateway);//return object payment
    }

    

}