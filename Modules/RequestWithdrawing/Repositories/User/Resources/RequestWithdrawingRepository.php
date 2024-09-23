<?php
namespace Modules\RequestWithdrawing\Repositories\User\Resources;

use App\Repositories\EloquentRepository;
use App\Traits\GeneralTrait;
use Modules\RequestWithdrawing\Repositories\User\Resources\RequestWithdrawingRepositoryInterface;
use Modules\RequestWithdrawing\Entities\Traits\User\RequestWithdrawingMethods;

class RequestWithdrawingRepository extends EloquentRepository implements RequestWithdrawingRepositoryInterface
{
    use GeneralTrait, RequestWithdrawingMethods;

}
  