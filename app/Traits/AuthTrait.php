<?php
namespace App\Traits;

use App\Models\RegisterCodeNum;
use App\Services\VonageCheckValidateNumber;
use App\Traits\EloquentTrait;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;

trait AuthTrait{
    use EloquentTrait;

    // Validate phone number and check its validity
    public function validatePhoneNo($phone, $country_id)
    {
        $phone_no = fullNumber($phone, $country_id);
        $response = app(VonageCheckValidateNumber::class)->checkPhoneNumberValidity($phone_no);
        return $response['message'] ? ['phone_no' => $phone_no] : $response;
    }

    // Get roles of the authenticated user by name
    public function rolesUserByName($user)
    {
        return authUser() && authUser()->id ? $user->roles->pluck('name')->toArray() : [];
    }

    // Get roles for a user by their ID using a model
    public function rolesUserByNameModel($model, $userId)
    {
        if (authUser()->id) {
            $user = $model->find($userId);
            return $user ? $user->roles->pluck('name') : collect();
        }
        return collect();
    }
    
    // Get role IDs of the authenticated user
    public function rolesUser($user)
    {
        return authUser() && authUser()->id ? $user->roles->pluck('id')->toArray() : [];
    }
    
    // Retrieve all users with a specific role by role name
    public function usersRole($nameRole)
    {
        $role = $this->find(Role::class, $nameRole, 'name');
        return $role ? $role->users : collect();
    }
    
    // Retrieve query builder for users with a specific role
    public function usersRoleRetrieve($nameRole)
    {
        $role = $this->find(Role::class, $nameRole, 'name');
        return $role ? $role->users() : collect();
    }
    
    // Get role IDs associated with a permission
    public function rolesPermission($permission)
    {
        return $permission->roles->pluck('id')->toArray();
    }
    
    // Get roles associated with a permission by ID
    public function rolesPermissionByName($model, $permissionId)
    {
        $permission = $model->find($permissionId);
        return $permission ? $permission->roles : collect();
    }
    
    // Redirect user based on their role
    public function redirectTo()
    {
        $user = authUser();
        if ($user->id) {
            $roles = $user->roles->pluck('name')->toArray();
            return in_array('superadmin', $roles) ? route(dashboard()) : route(home());
        }
        return route(home());
    }
    
    // Check if the user has one of the specified roles
    public function authorizeRole(array $roles)
    {
        $userRoles = $this->rolesUserByName(authUser());
        return empty(array_diff($roles, $userRoles));
    }
    
    // Check if a user exists and has the "user" role
    public function checkIsUser($id)
    {
        $user = User::where('id',$id)->first();
        // $user = User::find($id);
        return $user ? in_array('user', $user->roles->pluck('name')->toArray()) : 404;
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function failedAuthorization()
    {
        throw new AuthorizationException(trans('You havent Authorization to make this action'));
    }
    public function failedAction()
    {
        throw new AuthorizationException(trans('You cannt make this action'));
    }
    
    // Handle creation or retrieval of a user based on the model
    protected function handleUserCreationOrRetrieval($model, $infoUser)
    {
        return $model instanceof RegisterCodeNum
        ? $this->createUserFromInfo($infoUser)
        : $this->getExistingUser($infoUser);
    }
    
    // Retrieve an existing user by email or phone number
    protected function getExistingUser($infoUser)
    {
        return isset($infoUser->email)
            ? User::where('email', $infoUser->email)->first()
            : User::where(['phone_no' => $infoUser->phone_no, 'country_id' => $infoUser->country_id])->first();
    }
    
    // Create a new user based on provided info
    protected function createUserFromInfo($infoUser)
    {
        $userData = [
            'password' => $infoUser->password,
            'fcm_token' => $infoUser->fcm_token,
            'phone_no' => $infoUser->phone_no ?? null,
            'country_id' => $infoUser->country_id ?? null,
            'phone_verified_at' => isset($infoUser->phone_no) ? now() : null,
            'email' => $infoUser->email ?? null,
            'email_verified_at' => isset($infoUser->email) ? now() : null,
        ];
        $user = User::create($userData);
        $user->roles()->attach([3]); // Assign role to new user
        return $user;
    }
    
    // Verify user's phone number
    protected function verificationPhone($user)
    {
        $this->verifyUserAttribute($user, 'phone_verified_at');
    }
    
    // Verify user's email address
    protected function verificationEmail($user)
    {
        $this->verifyUserAttribute($user, 'email_verified_at');
    }
    
    // Private method to update verification attributes
    private function verifyUserAttribute($user, $attribute)
    {
        $user->update([$attribute => now()]);
    }

}
    


