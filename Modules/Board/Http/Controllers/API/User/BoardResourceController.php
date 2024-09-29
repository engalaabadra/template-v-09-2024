<?php

namespace Modules\Board\Http\Controllers\API\User;
use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use Modules\Board\Repositories\API\User\Resources\BoardRepository;
use Modules\Board\Entities\Board;
use Modules\Board\Resources\User\BoardResource;

class BoardResourceController extends Controller
{
    use GeneralTrait;
    /**
     * @var BoardRepository
     */
    protected $boardRepo;
        /**
     * @var Board
     */
    protected $board;

    
    /**
     * BoardResourceController constructor.
     *
     * @param BoardRepository $boards
     */
    public function __construct( Board $board,BoardRepository $boardRepo)
    {
        $this->board = $board;
        $this->boardRepo = $boardRepo;
    }
    /**
     * Display a listing of the resource via (all , pagination).
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boards = $this->boardRepo->getData($this->board, $this->board->eagerLoading);
        $data = BoardResource::collection($boards);
        if (page()) $data = getDataResponse($data);
        return successResponse(0, $data);
    }
}
