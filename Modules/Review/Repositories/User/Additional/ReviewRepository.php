<?php
namespace Modules\Review\Repositories\User\Additional;

use Modules\Review\Repositories\User\Additional\ReviewRepositoryInterface;
use Modules\Review\Entities\Traits\User\ReviewMethods;

class ReviewRepository implements ReviewRepositoryInterface
{
    use ReviewMethods;
   
}
