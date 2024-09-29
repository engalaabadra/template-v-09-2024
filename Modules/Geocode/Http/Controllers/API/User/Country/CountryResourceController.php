<?php

namespace Modules\Geocode\Http\Controllers\API\User\Country;
use App\Http\Controllers\Controller;
use App\Repositories\EloquentRepository;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Modules\Geocode\Repositories\API\User\Country\CountryRepository;
use Modules\Geocode\Entities\Country;
use Modules\Geocode\Resources\CountryResource;

class CountryResourceController extends Controller
{
    use GeneralTrait;
    /**
     * @var EloquentRepository
     */
    protected $eloquentRepo;
    /**
     * @var CountryRepository
     */
    protected $countryRepo;
        /**
     * @var Country
     */
    protected $country;
        /**
     * CountryController constructor.
     *
     * @param CountryRepository $countries
     */
    public function __construct(EloquentRepository $eloquentRepo, Country $country,CountryRepository $countryRepo)
    {
       $this->eloquentRepo = $eloquentRepo;
        $this->country = $country;
        $this->countryRepo = $countryRepo;
    }
    /**
     * Display a listing of the resource via (all , pagination).
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $countries=$this->countryRepo->getData($this->country);
        $data = CountryResource::collection($countries);
        if (page()) $data = getDataResponse($data);
        return successResponse(0,$data);
    }
}