<?php
namespace Modules\Movement\Repositories\User\Resources;

use App\Repositories\EloquentRepository;
use App\Traits\GeneralTrait;
use Modules\Movement\Repositories\User\Resources\MovementRepositoryInterface;
use Modules\Movement\Entities\Traits\User\MovementMethods;

class MovementRepository extends EloquentRepository implements MovementRepositoryInterface
{
    use GeneralTrait,MovementMethods;
}
