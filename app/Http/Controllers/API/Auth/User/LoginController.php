<?php

namespace App\Http\Controllers\API\Auth\User;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\Auth\Login\User\LoginRepository;
use Illuminate\Http\Request;
use App\Models\User;
use Modules\Profile\Resources\ProfileResource;

class LoginController extends Controller
{
    /**
     * @var LoginRepository
     */
    protected $loginRepo;
    /**
     * @var User
    */
    protected $user;

    public function __construct(LoginRepository $loginRepo,User $user){
        $this->loginRepo = $loginRepo;
        $this->user = $user;
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request){
        try{

            $login=  $this->loginRepo->login($request,$this->user);
            $errorResponse = isDataMissing($login);
            if ($errorResponse) return $errorResponse; // Return the error message if data is missing
            $data=[
                    "token"=>createToken($login),
                    "user" => new ProfileResource($login),
                ];
                return successResponse(0, $data,trans('auth.Logged in successfully'));
            }catch(CustomException $r){
            throw new CustomException('Something went wrong!', 422);

        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
   public function destroy(Request $request)
    {
        $logout=  $this->loginRepo->logout($request);
        $errorResponse = isDataMissing($logout);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return $logout ? successResponse(4) : serverError(0);
    }
}

