<?php

namespace Modules\Chat\Http\Controllers\API\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Chat\Repositories\User\Resources\ChatRepository;
use Modules\Chat\Entities\Chat;
use App\Traits\GeneralTrait;
use Modules\Chat\Resources\User\ChatResource;
use Modules\Chat\Http\Requests\User\StoreChatRequest;
use Modules\Chat\Http\Requests\User\DeleteAllChatsRequest;
use Modules\Chat\Http\Requests\User\UpdateChatRequest;

class ChatResourceController extends Controller
{
    use GeneralTrait;
    /**
     * @var ChatRepository
     */
    protected $chatRepo;
    /**
     * @var Chat
     */
    protected $chat;

    public $eagerLoading = ['file','files','client','user'];
    
    /**
     * ChatController constructor.
     *
     * @param ChatRepository $chats
     */
    public function __construct( Chat $chat,ChatRepository $chatRepo)
    {
        $this->chat = $chat;
        $this->chatRepo = $chatRepo;
    }

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $chats=$this->chatRepo->getData($this->chat,$this->chat->eagerLoading);
        $errorResponse = isDataMissing($chats);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        $data = ChatResource::collection($chats);
        if (page()) $data = getDataResponse($data);
        return successResponse(0,$data);
    }

    /**
     * store.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChatRequest $request){

        // \App\Models\User::findOrFail(99999); // This will throw a ModelNotFoundException

        $chat=$this->chatRepo->store($request,$this->chat,$this->chat->eagerLoading);
        $errorResponse = isDataMissing($chat);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return  successResponse(1,new ChatResource($chat));
        // throw new \Exception('This is a test exception.');

    }
    

  /**
     * Update the specified resource in storage.
     * @param Request $request 
     * @param int $id
     * @return Responsable
     */
    public function update(UpdateChatRequest $request,$id){
        $chat=$this->chatRepo->update($request,$id,$this->chat,$this->chat->eagerLoading);
        if(is_numeric($chat)) return clientError(4);
        if(is_string($chat)) return clientError(0,$chat);
        return successResponse(1,new ChatResource($chat));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chat= $this->chatRepo->destroy($id,$this->chat,$this->chat->eagerLoading);
        $errorResponse = isDataMissing($chat);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return successResponse(2,new ChatResource($chat));  
    }

    /**
     * Delete All the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll()
    {
        $chats= $this->chatRepo->deleteAll($this->chat);
        $errorResponse = isDataMissing($chats);
        if ($errorResponse) return $errorResponse; // Return the error message if data is missing
        return  successResponse(2,$chats);  
    }



}
