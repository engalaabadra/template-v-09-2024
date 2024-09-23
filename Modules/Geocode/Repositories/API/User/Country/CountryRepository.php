<?php
namespace Modules\Geocode\Repositories\API\User\Country;

use App\Repositories\EloquentRepository;
use Modules\Geocode\Repositories\API\User\Country\CountryRepositoryInterface;
use Modules\Geocode\Entities\Traits\Country\CountryMethods;
class CountryRepository extends EloquentRepository implements CountryRepositoryInterface
{
    use CountryMethods;

}
