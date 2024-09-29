<?php

namespace Modules\Chat\Http\Requests\User;

use App\Traits\GeneralTrait;
use Illuminate\Foundation\Http\FormRequest;



class UpdateChatRequest extends FormRequest
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
            'body' => ['required','max:10000'],
            'file'=>['mimes:jpeg,bmp,png,gif, svg'],
            'file'=>['mimes:pdf']
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
}
