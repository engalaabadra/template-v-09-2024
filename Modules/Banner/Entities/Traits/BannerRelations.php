<?php
namespace Modules\Banner\Entities\Traits;
use App\Models\File;
trait BannerRelations{
    
    public function file(){
        return $this->morphOne(File::class, 'fileable');
    }

}
