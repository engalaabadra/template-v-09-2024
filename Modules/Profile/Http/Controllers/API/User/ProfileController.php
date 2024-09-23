<?php

namespace Modules\Profile\Http\Controllers\API\User;

 
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Traits\GeneralTrait;
use Modules\Profile\Entities\Profile;
use Modules\Profile\Http\Requests\User\UpdateProfileRequest;
use Modules\Profile\Repositories\User\ProfileRepository;
use  Modules\Profile\Http\Requests\UpdatePasswordRequest;
use Modules\Profile\Resources\ProfileResource;

class ProfileController extends Controller
{
    use GeneralTrait;

     /**
     * @var ProfileRepository
     */
    protected $profileRepo;
    /**
     * @var User
     */
    protected $user;
    /**
     * @var Profile
     */
    protected $profile;
    
    /**
     * ProfileController constructor.
     *
     * @param ProfileRepository $Profile
     */
    public function __construct(  ProfileRepository $profileRepo, User $user, Profile $profile)
    {
         
        $this->profileRepo = $profileRepo;
        $this->user = $user;
        $this->profile = $profile;
    }


    /**
     * Show the specified resource.
     * @return Responsable
     */
    public function show()
    {
        $user=  $this->profileRepo->show($this->user);
        $errorResponse = isDataMissing($user);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return successResponse(0, new ProfileResource($user));
    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return Responsable
     */
    public function update(UpdateProfileRequest $request)
    {   
        $userId=authUser()->id;
        $user=$this->find($this->user,$userId,'id');
        $userUpdated=  $this->profileRepo->update($request,$this->profile,$user);
        $errorResponse = isDataMissing($userUpdated);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return successResponse(2, new ProfileResource($userUpdated));    
    }
    /**
     * Update password.
     * @param UpdatePasswordRequest $request
     * @return Responsable
     */
    public function updatePassword(UpdatePasswordRequest $request){
        $userUpdatedPassword=  $this->profileRepo->updatePassword($request,$this->user);   
        $errorResponse = isDataMissing($userUpdatedPassword);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return successResponse(2,new ProfileResource($userUpdatedPassword));
    }
}
