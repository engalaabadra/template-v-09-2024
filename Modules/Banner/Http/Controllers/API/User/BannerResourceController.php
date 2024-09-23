<?php

namespace Modules\Banner\Http\Controllers\API\User;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Cache;
use Modules\Banner\Repositories\API\User\Resources\BannerRepository;
use Modules\Banner\Entities\Banner;
use Modules\Banner\Resources\User\BannerResource;
class BannerResourceController extends Controller
{
    use GeneralTrait;
    /**
     * @var BannerRepository
     */
    protected $bannerRepo;
        /**
     * @var Banner
     */
    protected $banner;

    
    /**
     * BannerResourceController constructor.
     *
     * @param BannerRepository $banners
     */
    public function __construct( Banner $banner,BannerRepository $bannerRepo)
    {
        $this->banner = $banner;
        $this->bannerRepo = $bannerRepo;
    }
    /**
     * Display a listing of the resource via (all , pagination).
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = $this->bannerRepo->getData($this->banner, $this->banner->eagerLoading);
        $data = BannerResource::collection($banners);
        if (page()) $data = getDataResponse($data);
        Cache::put('banners', $data );
        return successResponse(0, Cache::get('banners'));
    }
}
