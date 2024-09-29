<?php
namespace Modules\Profile\Repositories\User;

use App\Models\User;
use App\Traits\GeneralTrait;
use Modules\Profile\Repositories\User\ProfileRepositoryInterface;
use Modules\Profile\Entities\Traits\GeneralProfileTrait;

class ProfileRepository implements ProfileRepositoryInterface{
    use GeneralTrait,GeneralProfileTrait;

    /**
     * show user profile.
     * @param User $model
     * @return object || @return int
     */
    public function show($model){
        $user = $this->find($model, authUser()->id);
        if(is_numeric($user)) return 404;
        return $user->load(['profile.file']);
    }
    /**
     * update profile.
     * @param UpdateProfileRequest $request
     * @param Profile $model
     * @param object $user
     * @return object
     */
    public function update($request,$model,$user){
        $data= $request->validated();
        $dataFillable = $model->fillable;
        //update info. in user table
        $enteredData= exceptData($data,$dataFillable);
        $user->update($enteredData);
        // Handle profile-related fields separately
        $this->checkDataProfile($model , $data, $user);
        if(!empty($data['file'])) $this->uploadFile($data['file'], 'profiles-files', 'App\Models\User', $user->profile);
        return $user->load(['profile.file']);
    }
    /**
     * update password.
     * @param UpdatePasswordRequest $request
     * @param User $model
     * @return object
     */
    public function updatePassword($request,$model){
        $user= $model->where(['id'=>authUser()->id])->first();
        $data=$request->validated();
        //check data for updating password && after check will update password
        $resultCheckPass = $this->checkDataPass($request,$user);
        if($resultCheckPass) return $resultCheckPass ;
        // Update password
        $user->password = $data['new_password'];//hashed default in model profile by motator
        $user->save();
        return $user;
    }
}

