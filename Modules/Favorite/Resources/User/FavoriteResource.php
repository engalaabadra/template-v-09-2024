<?php

namespace Modules\Favorite\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use GeneralTrait;
use Modules\Post\Resources\User\PostResource;
class FavoriteResource extends JsonResource
{
    use GeneralTrait;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'   => $this->id,
            'user'      => $this->user ? $this->user->id :null,
            'post'=> PostResource::make($this->post),            
        ];
    }
}
