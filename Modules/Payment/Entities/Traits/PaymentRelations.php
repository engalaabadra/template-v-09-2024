<?php
namespace Modules\Payment\Entities\Traits;
use Modules\Day\Entities\Day;
use App\Models\File;
use Modules\Payment\Entities\PaymentMethod;

trait PaymentRelations{
    public function file(){
        return $this->morphOne(File::class, 'fileable');
    }

    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class);
    }
}
