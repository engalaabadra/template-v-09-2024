<?php

namespace Modules\Payment\Services\PaymentGateways;

use Modules\Payment\Entities\Payment;

interface PaymentGatewayFactory{
    public function create($order,$user) : string;
    public function verify() : Payment;
}
