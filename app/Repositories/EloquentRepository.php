<?php

namespace App\Repositories;

use App\Traits\GeneralTrait;

use function PHPUnit\Framework\isEmpty;

class EloquentRepository
{
    use GeneralTrait;
    
    /** Get Data (all , pagination)
     * @param $model
     * @param $eagerLoading
     * @return array
     */
    public function getData($model, $eagerLoading = null)
    {
        $query = $model->where('main_lang', lang());
        if ($eagerLoading  && isEagerLoading()==1)  $query = $query->with($eagerLoading);
        return page() ?  $query->paginate() : $query->get();
    }
    /** search (all, pagination)
     * @param $model
     * @param $word
     * @return array
     */
    public function search($model, $words, $col = 'name')
    {
        return $model->where($col, 'like', '%' . $words . '%')->paginate();
    }

    /** trash (pagination)
     * @param $model
     * @return array
     */
    public function trash($model)
    {
        $trashedItems = $this->findAllItemsOnlyTrashed($model);
        if(isEmpty($trashedItems)) return 404;
        return $trashedItems->paginate();
    }
    /** store
     * @param $request
     * @param $model
     * @param $eagerLoading
     * @return object
     */
    public function store($request, $model, $eagerLoading = null)
    {
        return $this->action($request, $model, $eagerLoading);
    }
    /** store translation (via language)
     * @param $data
     * @param $model
     * @param $id
     * @return object
     */
    public function storeTrans($data, $model, $id)
    {
        // Use array_merge to cleanly assign translations
        $data = array_merge($data, [
            'translate_id' => $id,
            'main_lang' => getallheaders()['lang'] ?? localLang()
        ]);
        return $model->create($data);
    }
    /** Show
     * @param $id
     * @param $model
     * @param $eagerLoading
     * @return object
     */
    public function show($id, $model, $eagerLoading = null)
    {
        $item = $this->find($model, $id);
        if(!$item) return 404;
        return $eagerLoading ? $item->load($eagerLoading) : $item;
    }
    /** Update
     * @param $request
     * @param $id
     * @param $model
     * @param $eagerLoading
     * @return object
     */
    public function update($request, $id, $model, $eagerLoading = null)
    {
        return $this->action($request, $model, $eagerLoading,$id);
    }
    /** Restore
     * @param $id
     * @param $model
     * @return object
     */
    public function restore($id, $model)
    {
        $item = $this->findItemOnlyTrashed($id, $model);
        if(!$item) return 404;
        $item->restore();
        return $item;
    }
    /** Restore All
     * @param $model
     * @return array
     */
    public function restoreAll($model)
    {
        $items = $this->findAllItemsOnlyTrashed($model);
        if(isEmpty($items)) return 404;
        $items->restore();
        return $items;
    }
    /** Destroy
     * @param $id
     * @param $model
     * @param $eagerLoading
     * @return object
     */
    public function destroy($id, $model, $eagerLoading = null)
    {
        $item = $this->find($model, $id);
        if (is_numeric($item) || $item->deleted_at !== null)  return 404;
        $item->delete();
        if (isSoftDeletes($model))  return $eagerLoading ? $item->load($eagerLoading) : $item;
        else $this->handleFileDeletion($item);
        return $item;
    }

    /** Force Delete
     * @param $id
     * @param $model
     * @param $eagerLoading
     */
    public function forceDelete($id, $model, $eagerLoading = null)
    {
        $itemInTable = $this->find($id, $model);
        if(!$itemInTable) return 404;
        $itemInTrash = $this->findItemOnlyTrashed($id, $model);
        if(!$itemInTrash) return 404;
        $itemInTrash->forceDelete();
        if(in_array('file',$eagerLoading) && isset($itemInTrash->file)) $this->handleFileDeletion($itemInTrash);
        if(in_array('files',$eagerLoading) && isset($itemInTrash->files)) $this->handleFilesDeletion($itemInTrash->files);
    }
    /** Change Activate
     * @param $id
     * @param $model
     * @return object
     */
    public function changeActivate($id, $model)
    {
        $item = $this->find($model, $id, 'id');
        if(!$item) return 404;
        $item->update(['active' => $item->active == 1 ? 0 : 1]);
        return $item;
    }
}

