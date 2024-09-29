<?php
namespace Modules\Board\Entities\Traits;
use App\Models\File;

trait BoardRelations{
    public function file(){
        return $this->morphOne(File::class, 'fileable');
    }
}
