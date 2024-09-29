<?php
namespace Modules\Chat\Repositories\User\Resources;

use App\Models\User;
use App\Repositories\EloquentRepository;
use App\Traits\GeneralTrait;
use Modules\Chat\Repositories\User\Resources\ChatRepositoryInterface;
use Modules\Chat\Entities\Traits\User\ChatMethods;

class ChatRepository extends EloquentRepository implements ChatRepositoryInterface
{
    use GeneralTrait,ChatMethods;
    /**
     * Get data chat (all, pagination).
     * @param Chat $model
     * @param array $eagerLoading -> relation with model chat ['file','client','user']
     * @return array
     */
    public function getData($model, $eagerLoading = null)
    {
        $validationId = $this->validationIdMethod(clientId(),User::class);
        if($validationId) return $validationId;
        $query = $model->where(['client_id'=>clientId(),'user_id'=>authUser()->id]);
        if ($eagerLoading  && isEagerLoading()==1)  $query = $query->with($eagerLoading);
        return page() ?  $query->paginate(total()) : $query->get();
    }
    /** Store Chat
     * @param StoreChatRequest $request
     * @param Chat $model
     * @param array $eagerLoading -> ['file','client','user']
     * @return object
     */
    public function store($request,$model,$eagerLoading=null){
        return $this->actionMethod($request,$model,$eagerLoading);
    }
    /** Update Chat
     * @param UpdateChatRequest $request
     * @param  int $id
     * @param Chat $model
     * @param  array $eagerLoading -> ['file','client','user']
     * @return object
     */
    public function update($request, $id, $model, $eagerLoading = null)
    {
        return $this->actionMethod($request, $model, $eagerLoading,$id);
    }
    /** Destroy Chat
     * @param  int $id
     * @param Chat $model
     * @param  array $eagerLoading -> ['file','client','user']
     * @return object
     */
    //methods for deleting
    public function destroy($id, $model, $eagerLoading = null)
    {
        $item = $this->find($model, $id);
        if (is_numeric($item) || $item->deleted_at !== null)  return 404;
        if($this->checkUserOwnerItem($item)) return $this->checkUserOwnerItem($item);
        $item->delete();
        if (isSoftDeletes($model))  return $eagerLoading ? $item->load($eagerLoading) : $item;
        else $this->handleFilesDeletion($item);
        return $item;
    }

    /** Delete All chats
     * @param Chat $model
     */
    public function deleteAll($model){
        //check if this   a client
        $client=User::where('id',clientId())->first();
        $rolesclient= $this->rolesUserByName($client);
        if(!in_array('client',$rolesclient)) return trans('messages.This is Not a client  to delete chat with herself');
         //delete all
        $model->where(['user_id'=>authUser()->id,'client_id'=>clientId()])->truncate();
       
    }
}
