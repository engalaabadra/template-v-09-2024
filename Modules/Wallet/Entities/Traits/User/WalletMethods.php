<?php
namespace Modules\Wallet\Entities\Traits\User;

use App\Traits\GeneralTrait;
use Modules\Movement\Traits\MovementTrait;
trait WalletMethods{
    use GeneralTrait,MovementTrait;

    protected function getUrl($walletId,$amount){
        $url = $this->paymentProcessMethodWallet($walletId,$amount);
        return $url->errors[0]->description ?? $url;
    }
}

