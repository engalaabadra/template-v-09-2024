<?php
namespace Modules\Profile\Entities\Traits;
use App\Traits\GeneralTrait;
use Carbon\Carbon;

trait ProfileMethods{

    use GeneralTrait;
    /**
     * Handle profile-related fields separately.
     * @param Profile $model
     * @param UpdateProfileRequest $data
     * @param object $user
     * @return object
     */
    public function checkDataProfile($model, $data, $user)
    {
        // Check if any of the fields are present in the $data
            $profile = $this->find($model, $user->id, 'user_id');
            // Convert birth_date to Y-m-d format before saving
            $data['birth_date'] = Carbon::createFromFormat('d-m-Y', $data['birth_date'])->format('Y-m-d');
            // If profile is not found, create a new one and send welcome email
            if (is_numeric($profile)) {
                $data['user_id'] = $user->id;
                $model->create($data);
                $dataEmail = [
                    'email' => $user->email,
                    'user' => $user->full_name,
                    'type' => 'welcome',
                    'to' => 'user'
                ];
                //  app(SendingMessagesService::class)->sendingMessage($dataEmail);
            } else {
                // Update existing profile
                $profile->update($data);
            }
    }

    /**
     * check data for updating password.
     * @param UpdatePasswordRequest $data
     * @param object $user
     * @return string
     */
    public function checkDataPass($data,$user){
        if ($data['old_password'] === $data['new_password']) return trans('messages.You cannot modify your old password because the new password you entered is the same as the old one');
        if (!hashCheck($data['old_password'], $user->password)) return trans('messages.The old password is incorrect, please try again');
        if ($data['new_password'] !== $data['confirmation_new_password']) return trans('messages.Password does not match confirm password');
        
    }

}
