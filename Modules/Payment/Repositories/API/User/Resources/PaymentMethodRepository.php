<?php
namespace Modules\Payment\Repositories\User\Resources;

use Modules\Payment\Repositories\User\Resources\PaymentMethodRepositoryInterface;
use App\Repositories\EloquentRepository;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Session;
use  Modules\Payment\Entities\PaymentMethod;

class PaymentRepository extends EloquentRepository implements PaymentMethodRepositoryInterface
{
    use GeneralTrait,PaymentMethod;


    

}