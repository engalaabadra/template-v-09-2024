<?php
namespace Modules\Payment\Entities\Traits\User;

use Illuminate\Support\Facades\Session;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Entities\PaymentMethod;

trait PaymentMethods{
    //get payment , payment method , transaction
    protected function getPayment(){
        $paymentMethodSlug = Session::get('payment_method_id');
        $paymentMethod = PaymentMethod::where('slug',$paymentMethodSlug)->first();
        if(!$paymentMethod) return trans('messages.this slug payment method not found , pls select again');
        $transactionId = Session::get('transaction_id');
        $payment = Payment::where(['transaction_id'=>$transactionId])->first();
        if(!$payment) return 404;
        return [
            'payment_method'=>$paymentMethod,
            'payment'=>$payment,
            'transaction_id'=>$transactionId
        ];
    }
    protected function createPayment($order , $user , $response){
        $payment = Payment::create([
            // 'payment_method_id'=>$this->paymentMethod->id,
            'paymentable_id'=>$order->id,
            'paymentable_type'=>get_class($order),
            'payer_id'=>$user->id,
            'payer_type'=>get_class($user),
            'amount'=>$order->total,
            'currency_code'=>$order->currency_code,
            'type'=>'payment',
            'status'=>0,
            'transaction_id'=>$response->transaction->id,
            'payment_response'=>$response->result
        ]);
        return $payment;
    }
    protected function updatePayment($resultPayment,$response,$status){
        $resultPayment['payment_method_id'] = $resultPayment['payment_method']->id;
        $resultPayment['status'] = $status;
        $resultPayment['data']=$response;
        $resultPayment->save();
        return $resultPayment;
    }
}