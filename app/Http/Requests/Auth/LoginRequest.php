<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
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
            'password'=>['required'],
            'fcm_token'=>['sometimes'],
        ];
    }


    /**
     * Check if the user have the correct Credentials.
     * @param $request
     * @return object
     */
    public function checkLogin($request)
    {
        $emailOrPhone = $request->get('email') ?: $request->get('phone_no');
        $user = User::with('roles:name')
                ->where(function ($query) use ($emailOrPhone, $request) {
                    $query->where('email', $emailOrPhone)
                        ->orWhere(function ($query) use ($emailOrPhone, $request) {
                            $query->where('phone_no', $emailOrPhone)
                                    ->where('country_id', $request->get('country_id'));
                        });
                })
                ->first();
        if (!$user || !Hash::check($request->get('password'), $user->password)) return trans('messages.Invalid credentials');
        if ($request->has('fcm_token')) $user->update(['fcm_token' => $request->fcm_token]);
        
        return $user;
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
