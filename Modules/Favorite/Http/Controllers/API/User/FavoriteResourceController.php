<?php

namespace Modules\Favorite\Http\Controllers\API\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Favorite\Repositories\User\Resources\FavoriteRepository;
use Modules\Favorite\Entities\Favorite;
use GeneralTrait;
use Modules\Favorite\Resources\User\FavoriteResource;
use Modules\Favorite\Http\Requests\AddToFavoriteRequest;
class FavoriteResourceController extends Controller
{
    use GeneralTrait;
    /**
     * @var FavoriteRepository
     */
    protected $favoriteRepo;
    /**
     * @var Favorite
     */
    protected $favorite;

    
    /**
     * FavoriteResourceController constructor.
     *
     * @param FavoriteRepository $favorites
     */
    public function __construct( Favorite $favorite,FavoriteRepository $favoriteRepo)
    {
        $this->favorite = $favorite;
        $this->favoriteRepo = $favoriteRepo;
    }
    /**
     * Display a listing of the resource (all , pagination).
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $favorites = $this->favoriteRepo->getData($this->favorite,$this->favorite->eagerLoading);
        $data = FavoriteResource::collection($favorites);
        if (page()) $data = getDataResponse($data);
        return successResponse(0,$data);
    }
     /**
     * Store the  resource in storage.
     * @param Request $request 
     * @return Responsable
     * 
     * */
    public function store(AddToFavoriteRequest $request){
        $favorite=$this->favoriteRepo->store($request,$this->favorite,$this->favorite->eagerLoading);
        $errorResponse = isDataMissing($favorite);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return successResponse(1, new FavoriteResource($favorite));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $favorite= $this->favoriteRepo->destroy($this->favorite,$id,$this->favorite->eagerLoading);
        $errorResponse = isDataMissing($favorite);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return successResponse(2, new FavoriteResource($favorite));
    }

}
