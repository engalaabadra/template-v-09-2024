<?php
namespace Modules\Favorite\Entities\Traits;
use App\Models\User;
use Modules\Post\Entities\Post;

trait FavoriteRelations{
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function post(){
        return $this->belongsTo(Post::class);
    }
}
