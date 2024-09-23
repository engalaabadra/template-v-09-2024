<?php
namespace Modules\Favorite\Repositories\User\Resources;

use App\Repositories\EloquentRepository;
use App\Traits\GeneralTrait;
use Modules\Favorite\Entities\Traits\User\FavoriteMethods;
use Modules\Favorite\Repositories\User\Resources\FavoriteRepositoryInterface;

class FavoriteRepository extends EloquentRepository implements FavoriteRepositoryInterface
{
    use GeneralTrait,FavoriteMethods;

    /**
     * Get data Favorite (all, pagination).
     * @param Favorite $model
     * @param array $eagerLoading -> relation with model Favorite ['user']
     * @return array
     */
     public function getData($model, $eagerLoading = null)
    {
        $query = $model->where('user_id',authUser()->id);
        if($eagerLoading && isEagerLoading()==1) $query = $model->with($eagerLoading);
        return page() ?  $query->paginate(total()) : $query->get();
    }
    /** Store Favorite
     * @param StoreFavoriteRequest $request
     * @param Favorite $model
     * @param array $eagerLoading -> ['user']
     * @return object
     */
    public function store($request, $model, $eagerLoading = null)
    {
        $data = $request->validated();
        $data['user_id'] = authUser()->id;
        //check if this user add fav on this post before it -> will delete this fav on this post
        $favUserPost = $model->where(['user_id'=>$data['user_id'],'post_id'=>$data['post_id']])->first();
        if($favUserPost){
            $favUserPost->delete();
            return $favUserPost;
        }else{
            $item = $model->create($data);
            return $item->load($eagerLoading);
        }
    }
}
