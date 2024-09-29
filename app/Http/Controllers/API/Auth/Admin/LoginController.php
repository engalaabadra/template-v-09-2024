<?php

namespace App\Http\Controllers\API\Auth\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Repositories\Auth\Login\Admin\LoginRepository;
use Illuminate\Http\Request;
use App\Models\User;
use Modules\Profile\Resources\AdminResource;

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
        $result=  $this->loginRepo->login($request,$this->user);
        $errorResponse = isDataMissing($result);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        $data=[
            "token"=>createToken($result),
            // "admin" => new AdminResource($result),
        ];
        return successResponse(0, $data,trans('auth.Logged in successfully'));
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
   public function destroy(Request $request)
    {
        $result=  $this->loginRepo->logout($request);
        $errorResponse = isDataMissing($result);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        $result ? successResponse(4) : serverError(0);
    }
}

