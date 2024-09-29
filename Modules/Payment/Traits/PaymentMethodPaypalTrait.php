<?php
namespace Modules\Payment\Traits;
use  Modules\Payment\Entities\Traits\User\PaymentMethods;
trait PaymentMethodPaypalTrait{
    use PaymentMethods;

    protected function client(){
        if(!$this->client()){
            $client = new PaypalHttpClient(
                    new SandboxEnvironment(
                        $this->paymentMethod->options['client_id'],
                        $this->paymentMethod->options['client_secert'],
                        // env('PAYPAL_CLIENT_ID'),
                        // env('PAYPAL_CLIENT_SECRET'),
                    )
                );   
        }
        return $this->client;
        
    }
    protected function setDataPayment($order){
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
                        "intent"=>"CAPTURE",
                        'purchase_units' => [[
                            "reference_id"=>"test_ref_id1",
                            "amount"=>[
                                "value"=>$order->total,
                                "currency_code"=>$order->currency_code
                            ]
                        ]],
                        "application_context" => [
                            "cancel_url" => route('payment.cancel'),
                            "return_url" => route('payment.return'),
                        ]
            ];
        return $request;

    }
}
