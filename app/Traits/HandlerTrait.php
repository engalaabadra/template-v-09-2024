<?php
namespace App\Traits;
use Illuminate\Http\Request;

trait HandlerTrait{
    public function exceptions(){
        return response()->json([
            'message' => 'Internal Server Error',
        ], 500); // Respond with 500 Internal Server Error
        // Log::error($generalErr);
            // return 1;
        // return response()->json(['message' => 'Internal Server Error'], 500);
        return  new \Exception('Test Exception');


        // $this->reportable(function(\Exception $generalErr){

        //     return serverError(0);
        // });
        // $this->renderable(function(\QueryException $e, Request $req){
        //     if($e->getCode()==23000){
        //         $msg='Foreign key constraint faild';
        //     }else{
        //         $msg=$e->getMessage();
        //     }
        //     if($req->expectsJson()){
        //         return response()->json([
        //             'message'=>$msg
        //         ],400);
        //     }
        // });
        
    
       
    }
}
