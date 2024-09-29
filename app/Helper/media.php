<?php

/**
 * Generate a filename for storing media.
 *
 * @param \Illuminate\Http\UploadedFile $media
 * @return array
 */
function typesThumbnail($media): array
{
    if (empty($media)) return [];
    $filenameWithExtension = $media->getClientOriginalName();
    $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
    $extension = $media->getClientOriginalExtension();
    $filenameToStore = "{$filename}_" . time() . ".{$extension}";

    return ['filenameToStore' => $filenameToStore];
}

/**
 * Store a single file in a specified folder.
 *
 * @param \Illuminate\Http\UploadedFile $file
 * @param string $folderName
 * @return string
 */
function storeFileInFolder($file, string $folderName): string
{
    $resTypesThumbnail=    typesThumbnail($file); 
    // Store the file in the 'uploads' directory with a custom name
    $filePathOriginal =$file->storeAs('uploads/'.$folderName, $resTypesThumbnail['filenameToStore'],'public');
    return str_replace('public/', '', 'storage/'.$filePathOriginal);
}
/**
 * Store multiple files in in db.
 * @param array $fileData
 * @param  $modelName
 * @param object $item
 */
function storeMediaInDB($fileData, $modelName, $item, $isMultiple = true)
{
    if ($isMultiple) {//multiple files
        if ($item->files) {
            // Delete old files and update with new files
            $item->files()->delete();
            $item->files()->createMany($fileData);
        } else {
            // Create new files associated with the item
            $item->files()->createMany($fileData);
        }
    } else {// single file
        if ($item->file) {
            // Update the existing file
            $item->file()->update(['url' => $fileData]);
        } else {
            // Create a new file associated with the item
            $item->file()->create([
                'url' => $fileData,
                'fileable_id' => $item->id,
                'fileable_type' => $modelName
            ]);
        }
    }
}



function storeFile($fileData, string $folderName , object $item , $modelName)
{
    $urlFile = storeFileInFolder($fileData, $folderName);
    // Update or create image record associated with the item
    storeMediaInDB($urlFile, $modelName, $item , $isMultiple = false);

}

/**
 * Store multiple files in a specified folder & in db.
 *
 * @param array $files
 * @param string $folderName
 * @param object $item
 * @param $modelName
 * @return array
 */
function storeFiles(array $files, string $folderName , object $item , $modelName): array
{
    $storedFiles = [];
    foreach ($files as $file) {
        $urlFile = storeFileInFolder($file, $folderName);
        $storedFiles[] = ['url' => $urlFile];
        if (!$urlFile) throw new \Exception('File upload failed');
    }
    storeMediaInDB($storedFiles, $modelName, $item , $isMultiple = true);
    return $storedFiles;
}
