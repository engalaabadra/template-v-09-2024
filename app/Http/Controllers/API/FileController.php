<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadFilesRequest;
use App\Traits\GeneralTrait;

class FileController extends Controller
{
    use GeneralTrait;

    /**
     * Upload File.
     * @param UploadFilesRequest $request 
     * @return array
     * */
    public function storeFiles(UploadFilesRequest $request,$modelName,$id){
        $data = $request->validated();
        $modelClass = getModelClass($modelName);
        if(!$modelClass) return clientError(4);
        $model = resolve($modelClass);
        //check if this model is exist in models project
        $item=$this->find($model,$id);
        if(is_numeric($item)) return clientError(4);
        //check if this user owner this item to upload file
        $ownerItem = $this->checkUserOwnerItem($item);
        if(is_string($ownerItem)) return clientError(0,$ownerItem);
        $files = $this->uploadFiles($data['files'], $modelName . '-files', $modelName,  $item);
        return successResponse(0, $files);
    }
}
