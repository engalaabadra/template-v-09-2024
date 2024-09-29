<?php
namespace Modules\Board\Repositories\API\User\Resources;

use App\Repositories\EloquentRepository;
use App\Traits\GeneralTrait;
use Modules\Board\Entities\Board;
use Modules\Board\Repositories\API\User\Resources\BoardRepositoryInterface;
use Modules\Board\Entities\Traits\User\BoardMethods;

class BoardRepository extends EloquentRepository implements BoardRepositoryInterface
{
    use BoardMethods,GeneralTrait;

}