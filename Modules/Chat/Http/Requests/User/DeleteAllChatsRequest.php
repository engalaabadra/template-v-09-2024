<?php

namespace Modules\Chat\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use GeneralTrait;

/**
 * Class DeleteAllChatsRequest.
 */
class DeleteAllChatsRequest extends FormRequest
{
    use GeneralTrait;

    /**
     * Determine if the Chat is authorized to make this request.
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
            'doctor_id' => ['required','numeric','exists:users,id','required'],
        ];
    }
}
