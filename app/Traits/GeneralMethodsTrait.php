<?php
namespace App\Traits;

use App\Models\File;
use App\Models\User;
use App\Scopes\ActiveScope;
use Illuminate\Support\Facades\Storage;
use Modules\Geocode\Entities\Country;

trait GeneralMethodsTrait{
    use AuthTrait;
    protected function updateFcmMethod($request)
    {
        $data = $request->validated();
        // Directly update the FCM token for the authenticated user
        authUser()->update(['fcm_token' => $data['fcm_token']]);
        
        return authUser(); // Return the updated user instance
    }

    protected function filterData(array $data, array $exceptKeys)
    {
        // Use built-in array_diff_key instead of array_except (if Laravel version doesn't support array_except anymore)
        return array_diff_key($data, array_flip($exceptKeys));
    }

    protected function checkUserOwnerItem($item){
        $authUser = authUser();
        // Check if authenticated user owns the item
        if ($authUser && $item->user_id !== $authUser->id)  return trans('messages.you cannt make any thing here');
        // Check if session user owns the item (if session_id exists)
        if (!$authUser && isset($item->session_id) && $item->session_id !== sessionUser())  return trans('messages.you cannt make any thing here');
        
    }

    //for posts , comments
    protected function assignSessionItemsToUser($model,$user){ // Handle authenticated users and session-based posts
        ///this proccess will excute when get my posts immediatly not only add a post//
        // check if this user was entered by session before time ? 
        //if yes : will get these posts that put via session , to add in every post the user_id,
        // to become these posts appear to this user whether enter session or auth not only session , 
        //because this user same person enter by anuth or enter by session
        //current post will add via auth only but now logged in
        // $itemsSessionUser = $model->where('session_id',sessionUser())->where('user_id',null)->get(); //get all posts or comments that this session
        // foreach($itemsSessionUser as $itemSessionUser){//update these posts
        //     $itemSessionUser->update(['user_id'=>authUser()->id]);
        // }

                // Update all posts or comments for the current session where user_id is null
                $model::where('session_id', sessionUser())
->whereNull('user_id')
->update(['user_id' => $user->id]);
    }

    
    protected function validationId($id,$model){
        // Validate if ID exists and is numeric, then find the model item
        if (!$id || !is_numeric($id)) return trans('messages.must enter a valid numeric id');
        $item = $this->find($model,$id);
        if(is_numeric($item)) return 404;
    }
}
