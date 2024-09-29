<?php

namespace App\Http\Requests\Auth\User;

use App\Services\ProccessCodesService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use App\Services\SendingMessagesService;
use App\Traits\GeneralTrait;

/**
 * Class RegisterRequest.
 */
class RegisterRequest extends FormRequest
{
    use GeneralTrait;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required_without:phone_no|email|unique:users',
            'country_id' => 'required_with:phone_no|numeric|exists:countries,id',
            'phone_no' => 'required_without:email|numeric|regex:/^\d+$/|digits_between:7,14|exists:users,phone_no',
            'password' => ['required', Rules\Password::defaults()],
            'fcm_token' => ['sometimes'],
        ];
    }
    

    /**
    * Registration User In db .
    * @param RegisterRequest $request
    * @param RegisterCodeNum $model
    * @return object
    */
    public function actionRegister($request,$model){//model2:registerCodeNum
        $data=$request->validated();
        $data['code'] = getCode();
        if(session('info_user')){
            //check if this email || phoen entered again in register here
            $emailSession = isset(session('info_user')->email) ?? session('info_user')->email;
            $phone_noSession = isset(session('info_user')->phone_no) ?? session('info_user')->phone_no;
            if($request->input('email') == $emailSession) return trans('messages.You cannt enter same email again, you must check code now');
            if($request->input('phone_no') == $phone_noSession) return trans('messages.You cannt enter same phone_no again, you must check code now');
        }
        if ($request->filled('phone_no')) {
            $this->handlePhoneRegistration($model, $request, $data['code']);
        }
    
        if ($request->filled('email')) {
            $this->handleEmailRegistration($model, $request, $data['code']);
        }
        return $data;
    }

    /**
    * Handle Phone Registration .
    * @param RegisterCodeNum $model
    * @param RegisterRequest $request
    * @param string $code
    * @return int OR string
    */
    protected function handlePhoneRegistration($model, $request, $code)
    {
        $msg = "كود التفعيل: {$code} يرجى استخدامه فورًا.";
        $result = app(ProccessCodesService::class)->processPhone($model, $request, $code, $msg);
        $errorResponse = isDataMissing($result);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
    }
    /**
    * Handle Phone Registration .
    * @param RegisterCodeNum $model
    * @param RegisterRequest $request
    */
    protected function handleEmailRegistration($model, $request, $code)
    {
        app(ProccessCodesService::class)->processEmail($model, $request, $code);
    }

      /**
     * @return array
     */
    public function messages()
    {
        return [
        ];
    }

}

