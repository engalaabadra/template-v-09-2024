<?php
namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use function PHPSTORM_META\type;

trait MediaTrait{

    protected function uploadFile($fileData, $folderName, $modelName,  $item)
    {
       // Check if an file is uploaded -> will store it in folder, otherwise retain the existing file
       //Update or create file record associated with the item
       $file = request()->hasFile('file')
                    ? storeFile($fileData, $folderName , $item, $modelName) 
                    : $item->file;
        $fileData = ['url' => $file];
        return $item->file;
    }
    
    public function uploadFiles($fileData , $folderName, $modelName, $item){
        //Check if an file is uploaded -> will upload files in folder & update or store files in db
        return request()->hasFile('files')
                ? storeFiles($fileData,$folderName,$item,$modelName)
                : $item->files;
    }  
   
    protected function handleFileDeletion($item)
    {
        $fileItem = $item->file; // Direct relationship instead of query
        if ($fileItem) {
            $filePath = filePath($fileItem->url);
            
            // Delete file from storage and database if it exists
            if (Storage::exists($filePath)) Storage::delete($filePath);
            $fileItem->delete();
        }
    }

    protected function handleFilesDeletion($item)
    {
        $filesItems = $item->files;
        $deletedCount = 0;
        if(!empty($filesItems)){
            foreach ($filesItems as $fileItem) {
                $filePath = filePath($fileItem->url);
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                    $fileItem->delete();
                    $deletedCount++;
                }
            }
        }
        return $deletedCount;
        // $filesItems = $item->files;
        
        // if ($filesItems->isEmpty()) {
        //     return 0;
        // }

        // $deletedFiles = $filesItems->filter(function($fileItem) {
        //     $filePath = str_replace('/storage/', 'public/', $fileItem->url);
        //     if (Storage::exists($filePath)) {
        //         Storage::delete($filePath);
        //         $fileItem->delete();
        //         return true;
        //     }
        //     return false;
        // });
        // return $deletedFiles->count();
    }
}
