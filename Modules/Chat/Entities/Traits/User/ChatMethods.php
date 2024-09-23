<?php
namespace Modules\Chat\Entities\Traits\User;
use App\Models\User;
use App\Events\MessageCreated;
use App\Traits\GeneralTrait;

trait ChatMethods{
    use GeneralTrait;

    /**
     * Validation Id Method.
     * @param int $id
     * @param Chat $model
     * @return string || @return int 
     */
    protected function validationIdMethod($id,$model){
        if (!$id || !is_numeric($id)) return trans('messages.must enter a valid numeric id');
        $item = $this->find($model,$id);
        //check if this superadmin or admins,  cannt contact with her
        if(hasRole($item, 'admin') || hasRole($item, 'superadmin')) return 404;
        if(is_numeric($item)) return 404;
    }
    /**
     * Prepare Data Method.
     * @param array $data
     * @param Chat $model
     * @param object $item
     * @return object
     */
    //actions : store , update
    private function prepareDataMethod( $data, $model, $item=null)
    {
        //check if this client id exist in user table
        $enteredData = $this->filterData($data, ['file']);
        if ($item) $item->update($enteredData);
        else{
            if($this->validationIdMethod(clientId(),User::class)) return $this->validationIdMethod(clientId(),User::class);
            $user=authUser();
            $enteredData['user_id'] =  $user->id;
            $enteredData['sender_id']=$user->id;
            $enteredData['client_id']=clientId();
            $enteredData['recipient_id']=clientId();
           $item = $model->create($enteredData); 
           broadcast(new MessageCreated($item))->toOthers();
        }
        return $item;
    }
    /**
     * Action Method (Store || Update).
     * @param StoreChatRequest || @param UpdateChatRequest
     * @param Chat $model
     * @param $eagerLoading -> relation with model chat ['file','client','user']
     * @param int $id
     * @return string || @return int  || @return object
     */
    protected function actionMethod($request, $model, $eagerLoading = null, $id=null){
        $data = $request->validated();
        $item = $id ? $this->find($model, $id) : null;
        // Return 404 if item is not found
        if ($id && is_numeric($item)) return 404;
        if ($id && ($ownershipError = $this->checkUserOwnerItem($item)))  return $ownershipError;
        $result = $this->prepareDataMethod($data, $model, $item);
        if(is_numeric($result)) return 404;
        if(is_string($result)) return $result;
        return $eagerLoading ? $result->load($eagerLoading) : $result;
    }
}
