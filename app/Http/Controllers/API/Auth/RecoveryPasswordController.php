<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\PasswordReset;
use App\Models\User;
use App\Repositories\Auth\Recovery\Password\PasswordRepository;
use App\Http\Requests\Auth\CheckCodeRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use GeneralTrait;

class RecoveryPasswordController extends Controller
{
    use GeneralTrait;

    /**
     * @var PasswordRepository
     */
    protected $passwordRepo;
    /**
     * @var User
     */
    protected $user;
    /**
     * @var PasswordReset
     */
    protected $passwordReset;
    public function __construct(User $user,PasswordReset $passwordReset,PasswordRepository $passwordRepo){
        $this->user = $user;
        $this->passwordRepo = $passwordRepo;
        $this->passwordReset = $passwordReset;

    }
    /** Forgot Password 
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     */
    public function forgotPassword(ForgotPasswordRequest $request){
        $result =  $this->passwordRepo->forgotPassword($request,$this->passwordReset);
        $errorResponse = isDataMissing($result);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return successResponse(0,$result);
    }
    /** Check Code Recovery
     * @param CheckCodeRequest $request
     * @return JsonResponse
     */
    public function checkCodeRecovery(CheckCodeRequest $request){
        $result= $this->passwordRepo->checkCode($request,$this->passwordReset);
        $errorResponse = isDataMissing($result);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return successResponse(0,$result);
    }
    /** Resend Code Recovery
     * @return JsonResponse
     */
    public function resendCodeRecovery(){
        $result= $this->passwordRepo->resendCode($this->passwordReset);
        $errorResponse = isDataMissing($result);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return successResponse(0,$result);
    }

    /** Reset Password
     * @param ResetPasswordRequest $request
     * @return JsonResponse
     */
    public function resetPassword(ResetPasswordRequest $request){
        $result=$this->passwordRepo->resetPassword($request);
        $errorResponse = isDataMissing($result);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return successResponse(0,$result);
    }

}
