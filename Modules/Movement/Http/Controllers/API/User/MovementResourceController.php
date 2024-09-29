<?php

namespace Modules\Movement\Http\Controllers\API\User;
use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Modules\Movement\Repositories\User\Resources\MovementRepository;
use Modules\Movement\Entities\Movement;
use Modules\Movement\Resources\User\MovementResource;

class MovementResourceController extends Controller
{
    use GeneralTrait;
    /**
     * @var MovementRepository
     */
    protected $movementRepo;
        /**
     * @var Movement
     */
    protected $movement;
    
    /**
     * MovementResourceController constructor.
     *
     * @param MovementRepository $movements
     */
    public function __construct( Movement $movement,MovementRepository $movementRepo)
    {
        $this->movement = $movement;
        $this->movementRepo = $movementRepo;
    }
    /**
     * Display a listing of the resource via (all , pagination).
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $movements = $this->movementRepo->getData($this->movement,$this->movement->eagerLoading);
        $data = MovementResource::collection($movements);
        if (page()) $data = getDataResponse($data);
        return successResponse(0,$data);
    }
}
