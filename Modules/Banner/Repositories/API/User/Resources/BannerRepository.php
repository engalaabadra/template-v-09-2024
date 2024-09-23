<?php
namespace Modules\Banner\Repositories\API\User\Resources;

use App\Repositories\EloquentRepository;
use App\Traits\GeneralTrait;
use Modules\Banner\Repositories\API\User\Resources\BannerRepositoryInterface;
use Modules\Banner\Entities\Traits\User\BannerMethods;

class BannerRepository extends EloquentRepository implements BannerRepositoryInterface
{
    use BannerMethods,GeneralTrait;
    

}
