<?php
namespace App\Traits;
use Illuminate\Http\Request;

trait HandlerTrait{
    public function exceptions(){
        $this->reportable(function(\Exception $generalErr){
            return serverError(0);
        });
        $this->renderable(function(\Illuminate\Database\QueryException $e, Request $req){
            if($e->getCode()==23000){
                $msg='Foreign key constraint faild';
            }else{
                $msg=$e->getMessage();
            }
            if($req->expectsJson()){
                return response()->json([
                    'message'=>$msg
                ],400);
            }
        });

       
    }
}
