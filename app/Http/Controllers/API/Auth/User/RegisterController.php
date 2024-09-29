<?php

namespace App\Http\Controllers\API\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CheckCodeRequest;
use App\Http\Requests\Auth\User\RegisterRequest;
use App\Models\RegisterCodeNum;
use App\Services\ProccessCodesService;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Repositories\Auth\Register\User\RegisterRepository;
use App\Traits\GeneralTrait;

class RegisterController extends Controller
{
    use GeneralTrait;

    /**
     * @var RegisterRepository
     */
    protected $regRepo;
    /**
     * @var User
     */
    protected $user;
    /**
     * @var RegisterCodeNum
     */
    protected $registerCodeNum;

    public function __construct(RegisterRepository $regRepo, User $user, RegisterCodeNum $registerCodeNum)
    {
        $this->regRepo = $regRepo;
        $this->user = $user;
        $this->registerCodeNum = $registerCodeNum;
    }

    /**
     * Register
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $regUser = $this->regRepo->register($request, $this->registerCodeNum);
        $errorResponse = isDataMissing($regUser);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return  successResponse(0, $regUser, trans('auth.Congrats...Registration completed successfully'));

    }

    /** check Code Register
     * @param CheckCodeRequest $request
     * @return JsonResponse
     */
    public function checkCodeRegister(CheckCodeRequest $request)
    {
        $data = $request->validated();
        $resultCodeUser = app(ProccessCodesService::class)->checkCode($this->registerCodeNum, $data['code']);
        $errorResponse = isDataMissing($resultCodeUser);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return successResponse(0, $resultCodeUser, trans('auth.Thanks,The code is valid'));

        }

    /** Resend Code Register
     * @return JsonResponse
     */
    public function resendCodeRegister(): JsonResponse
    {
        //get data info_user from session
        $info_user=session('info_user');
        $code = getCode();
        if (isset($info_user->phone_no)){
            $result = app(ProccessCodesService::class)->processPhone($this->registerCodeNum,$info_user,$code);
            $errorResponse = isDataMissing($result);
            if ($errorResponse) return $errorResponse; // Return the error message if data is missing        
        }
        if (isset($info_user->email)){
            $result = app(ProccessCodesService::class)->processEmail($this->registerCodeNum,$info_user,$code);
            $errorResponse = isDataMissing($result);
            if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        }
        return successResponse(0, $info_user);
    }
}

