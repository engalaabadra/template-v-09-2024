<?php

namespace Modules\Review\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use GeneralTrait;
use Illuminate\Validation\Rule;


class AddReviewRequest extends FormRequest
{
    use GeneralTrait;

    /**
     * Determine if the Review is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //Add Review for only superadmin        
        $authorizeRes= $this->authorizeRole(['user']);
        if($authorizeRes==true){
            return true;
        }else{
            return $this->failedAuthorization();
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'doctor_id' => ['numeric','exists:users,id','required'],
            'reservation_id' => ['numeric','exists:reservations,id','required'],
            'description'=>['nullable'],
            'rating'=>['required','numeric'],
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
