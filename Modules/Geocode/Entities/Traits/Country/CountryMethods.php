<?php
namespace Modules\Geocode\Entities\Traits\Country;

use App\Scopes\ActiveScope;

trait CountryMethods{
    
    protected function getRelationCitiesCountry($model,$countryId){
        $country=$this->find($countryId,$model);
        if(is_string($country)){
            return $country;
        }
        $citiesCountry = $country->cities()->paginate(total());
        return  $citiesCountry;
    }
}
