<?php
namespace App\Repositories\Auth\Recovery\Password;

use App\Services\MsegatSmsService;
use App\Services\ProccessCodesService;
use App\Traits\GeneralTrait;
use App\Models\User;
use App\Services\SendingMessagesService;

class PasswordRepository  implements PasswordRepositoryInterface{
    use GeneralTrait;
    /**
    * Forgot Password .
    * @param ForgotPasswordRequest $request
    * @param User $model
    * @param string $code
    * @return object
    */
    public function forgotPassword($request,$model){//model: password_resets , model1: user
        $code = getCode();
        $result =  $request->processForgotPassword($request,$code,$model);
        session(['info_user'=>(object)$result]);
        return $result;
    }
    /**
    * Check Code .
    * @param CheckCodeRequest $request
    * @param User $model
    * @return object
    */
    public function checkCode($request,$model){
        $data= $request->validated();
        $objectCode= app(ProccessCodesService::class)->checkCode($model,$data['code']);
        if(is_string($objectCode)) return  $objectCode;
        $infoUser = session('info_user');
        $data = $request->prepareMessageData($model, $infoUser);
        // app(SendingMessagesService::class)->sendingMessage($data);
        return $objectCode;
    }
    /** Resend Code
    * @param PasswordReset $model
    * @return object
    */
    public function resendCode($model){
        //get data info_user from session
        $infoUser=session('info_user');
        if(!$infoUser) return trans('messages.You must make forgot password before this');
        // Generate a new password reset code
        $code = getCode();
        // Process based on available phone number or email
        $result = $this->processContactMethod($model, $infoUser, $code);
        if(is_string($result)) return $result;
        $infoUser->code = $code;
        return [
            'email'=>isset($infoUser->email) ? $infoUser->email : null,
            'phone_no'=>isset($infoUser->phone_no) ? $infoUser->phone_no : null,
            'code'=>$infoUser->code
        ];
    }
    /** Process Contact Method 
    * Resend Code .
    * @param PasswordReset $model
    */
    private function processContactMethod($model, $infoUser, $code)
    {
        // Process phone number if it exists
        if (isset($infoUser->phone_no)) {
            $msg = "رمز تغيير كلمة المرور: " . $code . " يرجى استخدامه فورًا.";
            return app(ProccessCodesService::class)->processPhone($model, $infoUser, $code, $msg);
        }
        // Process email if it exists
        if (isset($infoUser->email)) {
            return app(ProccessCodesService::class)->processEmail($model, $infoUser, $code);
        }
        return trans('messages.No valid contact information found.');
    }
    
    public function resetPassword($request)
    {
        $data = $request->validated();
        // Fetch the user based on email or phone number
        $resultUser = $request->findUserByContact($request);
        if (!$resultUser)  return trans('messages.User not found');
        $resultUser->update(['password'=>$data['password']]);
        return $resultUser->toArray();
    }

}
