<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Banner\Http\Controllers\API\BannerResourceController;
use App\Http\Controllers\API\User\DoctorController;
use Modules\Specialty\Http\Controllers\API\User\SpecialtyController;
use GeneralTrait;
use App\Models\MobileVersion;
use Modules\Reservation\Entities\Reservation;
use Modules\Reservation\Resources\User\ReservationResource;

class HomeController extends Controller
{
    use GeneralTrait;
    /**
     * @var BannerResourceController
     */
    protected $bannerController;
    /**
     * @var DoctorController
     */
    protected $doctorController;
    /**
     * @var SpecialtyController
     */
    protected $specialtyController;
    
    /**
     * HomeController constructor.
     *
     * @param BannerResourceController $bannerController
     */
    public function __construct(BannerResourceController $bannerController,DoctorController $doctorController,SpecialtyController $specialtyController)
    {
       $this->bannerController = $bannerController;
       $this->doctorController = $doctorController;
       $this->specialtyController = $specialtyController;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $banners=$this->bannerController->index($request);
        $originalBanners=$banners->original;
        $mobileVersions=MobileVersion::get();

        if(!authUser()){
           $data = [

           ];
        }else{
            $data = [

            ];
        }
        return successResponse(0,$data);
    }



}
