<?php

namespace Modules\Wallet\Http\Controllers\API\User;
use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Modules\Wallet\Repositories\User\Resources\WalletRepository;
use Modules\Wallet\Entities\Wallet;
use Modules\Wallet\Resources\User\WalletResource;
use Modules\Wallet\Http\Requests\AddIntoWalletRequest;
use Modules\Wallet\Entities\Traits\User\WalletMethods;
class WalletResourceController extends Controller
{
    use GeneralTrait,WalletMethods;
    /**
     * @var WalletRepository
     */
    protected $walletRepo;
        /**
     * @var Wallet
     */
    protected $wallet;
    
    public $eagerLoading = ['user'];
    /**
     * WalletResourceController constructor.
     *
     * @param WalletRepository $wallets
     */
    public function __construct( Wallet $wallet,WalletRepository $walletRepo)
    {
        $this->wallet = $wallet;
        $this->walletRepo = $walletRepo;
    }
    /**
     * Display a listing of the resource via (all , pagination).
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $wallet=$this->walletRepo->balance($this->wallet,$this->wallet->eagerLoading);
        $data = new WalletResource($wallet);
        return successResponse(0,$data);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddIntoWalletRequest $request)
    {
        $result=  $this->walletRepo->store($request,$this->wallet,$this->wallet->eagerLoading);
        $errorResponse = isDataMissing($result);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return  successResponse(0,$result);
    }
}
