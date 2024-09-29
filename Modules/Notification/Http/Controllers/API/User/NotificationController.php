<?php

namespace Modules\Notification\Http\Controllers\API\User;
use App\Http\Controllers\Controller;
use App\Services\SendingNotificationsService;
use Illuminate\Http\Request;
use Modules\Notification\Repositories\User\NotificationRepository;
use Modules\Notification\Entities\Notification;
use GeneralTrait;
use App\Traits\GeneralMethodsTrait;
use Modules\Notification\Resources\User\NotificationResource;
use Modules\Notification\Http\Requests\UpdateFcmRequest;
use Modules\Notification\Http\Requests\SendNotificationRequest;

class NotificationController extends Controller
{
    use GeneralTrait,GeneralMethodsTrait;
    /**
     * @var NotificationRepository
     */
    protected $notificationRepo;
        /**
     * @var Notification
     */
    protected $notification;
    

    /**
     * NotificationController constructor.
     *
     * @param NotificationRepository $notifications
     */
    public function __construct( Notification $notification,NotificationRepository $notificationRepo)
    {
        $this->notification = $notification;
        $this->notificationRepo = $notificationRepo;
    }
    /**
     * Display a listing of the resource via (all , pagination).
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $notifications=$this->notificationRepo->getData($this->notification,$this->notification->eagerLoading);
        $data = NotificationResource::collection($notifications);
        if (page()) $data = getDataResponse($data);
        return successResponse(0,$data);
    }
    public function updateFcm(UpdateFcmRequest $request){
        $user=$this->updateFcmMethod($request);
        return successResponse(2,$user);
    }
    public function sendNotificationMethod(SendNotificationRequest $request,$userId){
        $data=$request->validated();
        $notification=app(SendingNotificationsService::class)->sendNotification($data,$userId,$type=null);
        $errorResponse = isDataMissing($notification);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return successResponse(2,$notification->load($this->notification->eagerLoading));
    }
}

