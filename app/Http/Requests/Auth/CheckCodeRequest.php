<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use Illuminate\Validation\Rules;
use App\Models\User;


/**
 * Class CheckCodeRequest.
 */
class CheckCodeRequest extends FormRequest
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
            'code' => ['required'],
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
    /**
    * Prepare Message Data .
    * @param RegisterCodeNum $model
    * @param RegisterRequest $request
    * @param string $code
    * @return int OR string
    */
    public function prepareMessageData($model, $infoUser)
    {
        $commonData = [
            'code' => $infoUser->code,
        ];
    
        if ($model instanceof \App\Models\RegisterCodeNum) {
            return array_merge($commonData, [
                'data-user' => $infoUser->email ?? $infoUser->phone_no,
                'type' => 'welcome',
            ]);
        } elseif ($model instanceof \App\Models\PasswordReset) {
            return array_merge($commonData, [
                'email' => $infoUser->email ?? null,
                'phone_no' => $infoUser->phone_no ?? null,
                'type' => 'check-code',
            ]);
        }
        return $commonData;
    }

}
