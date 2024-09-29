<?php
namespace Modules\Notification\Repositories\User;

use App\Repositories\EloquentRepository;
use App\Traits\GeneralTrait;
use Modules\Notification\Entities\Traits\User\NotificationMethods;
use Modules\Notification\Repositories\User\NotificationRepositoryInterface;


class NotificationRepository extends EloquentRepository implements NotificationRepositoryInterface
{
    use NotificationMethods,GeneralTrait;
    

}
