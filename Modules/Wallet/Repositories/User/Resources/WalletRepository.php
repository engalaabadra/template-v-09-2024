<?php
namespace Modules\Wallet\Repositories\User\Resources;

use App\Repositories\EloquentRepository;
use App\Traits\GeneralTrait;
use Modules\Wallet\Repositories\User\Resources\WalletRepositoryInterface;
use Modules\Wallet\Entities\Traits\User\WalletMethods;

class WalletRepository extends EloquentRepository implements WalletRepositoryInterface
{
    use GeneralTrait,WalletMethods;
    ///get data//
    public function balance($model,$eagerLoading){
        $user=authUser();
        $wallet=$model->where(['user_id'=>$user->id])->first();
        return  $wallet->load($eagerLoading);
    }
    public function store($request,$model,$eagerLoading=null){
        $data = $request->validated();
        $user=authUser();
        $wallet=$model->where(['user_id'=>$user->id])->first();
        $amount = $data['amount'];
        $url = $this->getUrl($wallet->id,$amount);
        return  [
                    'url'=>$url,
                    'wallet'=>$wallet->load($eagerLoading),
                ];
    }

}
