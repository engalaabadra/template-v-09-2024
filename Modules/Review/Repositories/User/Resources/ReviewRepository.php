<?php
namespace Modules\Review\Repositories\User\Resources;

use App\Repositories\EloquentRepository;
use App\Traits\GeneralTrait;
use Modules\Review\Repositories\User\Resources\ReviewRepositoryInterface;
use Modules\Review\Entities\Traits\User\ReviewMethods;

class ReviewRepository extends EloquentRepository implements ReviewRepositoryInterface
{
    use GeneralTrait,ReviewMethods;


}
