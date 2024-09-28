<?php

namespace Modules\Payment\Services\PaymentGateways;

use Carbon\Exceptions\Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Entities\PaymentMethod;
use Modules\Payment\Services\PaymentGateways\PaymentGatewayFactory;
use Modules\Payment\Traits\PaymentMethodPaypalTrait;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Paypal implements PaymentGatewayFactory
{
    use PaymentMethodPaypalTrait;

    protected $paymentMethod;
    protected $options;
    protected $client;
    public function __construct(PaymentMethod $paymentMethod , $options)
    {
        $this->paymentMethod = $paymentMethod;
        $this->options = $options;
    }



   public function create($order, $user) : string
   {
        $data = $this->setDataPayment($order);
        try{
            $response = $this->client->execute($data);
            if($response->rel == 'approve'){
                $payment = $this->createPayment($order , $user , $response);
                //store transaction id , payment id in session
                Session::put('transaction_id',$response['session_id']);
                Session::put('payment_id',$payment->id);
                return View::make(
                    'payment.stripe',
                    compact('payment','link')
                );
                return $link->href;
            }
        } catch (Exception $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage);

        }
   }

   public function verify() : Payment//when click on pay now
   {
        $resultPayment = $this->getPayment();
        $request = new OrdersCaptureRequest("APPROVED-ORDER-ID");
        $request->prefer('return=representation');
        try{
            $response = $this->client->execute($request);
            if($response->result->status == 'COMPLETED'){
                $payment = $this->updatePayment($resultPayment,$response,1);
            }elseif($response->result->status == 'CANCELED'){
                $payment = $this->updatePayment($resultPayment,$response,-1);
            }
            Session::forget(['payment_id','session_id']);
            return $payment;
        }catch(HttpException $ex){
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
   }

//    public function formOption() : array
//    {
    
//    }
}
