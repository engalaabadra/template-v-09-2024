<?php
namespace App\Traits;

use App\Scopes\ActiveScope;
use Modules\Geocode\Entities\Country;

trait EloquentTrait{

    private function prepareData($data, $model,$item=null)
    {
        // Filter out 'file' key and either update or create the model item
        $enteredData = $this->filterData($data, ['file']);
        $item = $item ? $item->update($enteredData) : $model->create($enteredData);
        $modelName = modelName($model);
        if (isset($data['file']))  $this->uploadFile($data['file'], $modelName . '-files', $modelName, $item);
        return $item;
    }

    protected function action($request, $model, $eagerLoading = null, $id=null){
        $data = $request->validated();
        $item = $id ? $this->find($model, $id) : null;
        // Return 404 if item is not found
        if ($id && is_numeric($item)) return 404;
        $item = $this->prepareData($data, $model,$item);
        return $eagerLoading ? $item->load($eagerLoading) : $item;
    }

    // Methods for finding items
    protected function findIntroPhone($countryId)
    {
        return Country::where('id', $countryId)->value('phone_code');
    }
    
    protected function find($model, $data, $colName = 'id')
    {
        // Build query and return the first match or abort
        $query = $this->buildQuery($model, isSoftDeletes($model));
        return $query->where($colName, $data)->first() ?: 404;
    }
   
    protected function buildQuery($model, $isSoftDeletes)
    {
        // Use either the model string or instance to build the query
        $query = is_string($model) ? $model::withoutGlobalScope(ActiveScope::class) : $model->withoutGlobalScope(ActiveScope::class);
        // Include soft-deleted records if necessary
        // if ($isSoftDeletes) $query = $query->withTrashed();
        return $query;
    }   

}
