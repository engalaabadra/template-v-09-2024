<?php
namespace Modules\Contact\Entities\Traits;

use App\Traits\GeneralTrait;
use Modules\Payment\Entities\PaymentMethod;
use Modules\Payment\Services\PaymentGateways\PaymentGatewayFactory;
use Modules\Payment\Traits\PaymentMethodTrait;

trait OrderMethods {
    use GeneralTrait,PaymentMethodTrait;

    //make checkout -> will call method for register a payment for this order to return a url in meth checkout here
    //which is this url after this checkout , will click on it to open a page payment to complete proccess payment
    public function actionMethod($request,$model,$id=null){//
        $data = $request->validated();
        //create an order
        $order = $model->create($data);
        $user = authUser();
    //when checkout will select  payment method :  slug payment meth 
        $data = $request->validated();
        $order = Order::create([
            'total'=>100
        ]);
        ///if select wallet 
        //will store this movement ->status pending & balance 
        //in callback will store another movement ->status success & same balance & decrease from wallet

        //will select gateway : tap , thawani , paypal
        $gateway = PaymentMethod::where('slug',$data['payment_method'])->first();

        return $gateway->create($order,authUser());//call meth create from file this gateway   , will return url to open a page payment     
    
    }

}