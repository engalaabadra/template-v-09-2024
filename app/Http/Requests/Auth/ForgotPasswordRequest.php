<?php

namespace App\Http\Requests\Auth;

use App\Services\MsegatSmsService;
use App\Services\ProccessCodesService;
use App\Traits\GeneralTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use Illuminate\Validation\Rules;
use App\Models\User;
/**
 * Class ForgotPasswordRequest.
 */
class ForgotPasswordRequest extends FormRequest
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
            'email' => 'required_without:phone_no|email|exists:users,email',
            'country_id' => 'required_with:phone_no|numeric|exists:countries,id',
            'phone_no' => 'required_without:email|numeric|regex:/^\d+$/|digits_between:7,14|exists:users,phone_no',
            
        ];
    }
    /**
     * Process Forgot Password.
     *
     * @return array
     */
    public function processForgotPassword($request,$code,$model){//model :reset_passd
        $data=$request->validated();
        $data['code'] = getCode();
        if ($request->has('phone_no')) {
            $msg ="رمز تغيير كلمة المرور:" . $data['code']." يرجى استخدامه فورًا.";
            $result = app(ProccessCodesService::class)->processPhone($model,$request,$data['code'],$msg);
            if(is_string($result)) return $result;
        } if ($request->has('email')) {
            $result = app(ProccessCodesService::class)->processEmail($model,$request,$data['code']);
            if(is_string($result)) return $result;
        }
        return $data;

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
