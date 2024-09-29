<?php

namespace Modules\Review\Http\Controllers\API\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Review\Repositories\User\Resources\ReviewRepository;
use Modules\Review\Entities\Review;
use GeneralTrait;
use Modules\Review\Resources\User\ReviewResource;
use Modules\Review\Http\Requests\User\AddReviewRequest;
use Modules\Review\Http\Requests\User\UpdateReviewRequest;
class ReviewResourceController extends Controller
{
    use GeneralTrait;
    /**
     * @var ReviewRepository
     */
    protected $reviewRepo;
        /**
     * @var Review
     */
    protected $review;

    
    /**
     * ReviewResourceController constructor.
     *
     * @param ReviewRepository $reviews
     */
    public function __construct( Review $review,ReviewRepository $reviewRepo)
    {
        $this->review = $review;
        $this->reviewRepo = $reviewRepo;
    }
    /**
     * Display a listing of the resource (all , pagination).
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $reviews = $this->reviewRepo->getData($this->review,$this->review->eagerLoading);
        $data = ReviewResource::collection($reviews);
        if (page()) $data = getDataResponse($data);
        return successResponse(0,$data);
    }
    /**
     * store.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AddReviewRequest $request){
        $review=$this->reviewRepo->store($request,$this->review,$this->review->eagerLoading);
        $errorResponse = isDataMissing($review);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return successResponse(1, new ReviewResource($review));
    }
    /**
     * update.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReviewRequest $request,$id){
        $review=$this->reviewRepo->update($request,$id,$this->review,$this->review->eagerLoading);
        $errorResponse = isDataMissing($review);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return  successResponse(1,new ReviewResource($review));
    }
    /**
     * destroy.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $review=$this->reviewRepo->destroy($id,$this->review,$this->review->eagerLoading);
        $errorResponse = isDataMissing($review);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return  successResponse(2,new ReviewResource($review));
    }
  

}
