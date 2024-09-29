<?php

namespace App\Http\Controllers\WEB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Barryvdh\Debugbar\Facades\Debugbar;
use GeneralTrait;

class HomeController extends Controller
{
    use GeneralTrait;
    
    /**
     * HomeController constructor.
     *
     * @param BannerResourceController $bannerController
     */
    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        Debugbar::error('alaa err');

    }



}
