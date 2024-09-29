<?php
namespace App\Traits;
trait GeneralAttributesTrait{
    //Accessories
    public function getActiveAttribute()
    {
        return $this->attributes['active'] ?? null;
    }

    public function getOriginalActiveAttribute()
    {
        return isset($this->attributes['active']) 
            ? trans($this->attributes['active'] ? 'attributes.Active' : 'attributes.Not Active')
            : null;
    }
    //mutators

    
}
