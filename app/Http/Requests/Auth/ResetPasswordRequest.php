<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rules;

/**
 * Class ResetPasswordRequest.
 */
class ResetPasswordRequest extends FormRequest
{

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
            'password'=>['required', Rules\Password::defaults(),'confirmed'],
            'email' => 'required_without:phone_no|email|exists:users,email',
            'country_id' => 'required_with:phone_no|numeric|exists:countries,id',
            'phone_no' => 'required_without:email|numeric|regex:/^\d+$/|digits_between:7,14|exists:users,phone_no',
            
        ];
    }
    /**
     * @return array
     */
    public function messages()
    {
        return [

        ];
    }
    public function findUserByContact($request)
    {
        // Check if the email is provided and find the user by email
        if (isset($request->email))  return User::where('email', 'like', $request->email)->first();
        // Check if phone is provided and find the user by phone
        elseif(isset($request->phone_no)) return User::where(['phone_no'=> $request->phone_no , 'country_id'=> $request->country_id])->first();
    }

}
