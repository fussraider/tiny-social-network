<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\DeleteEntityRequest;
use App\Http\Requests\EditEntityRequest;
use App\Http\Requests\LikeRequest;
use App\Http\Requests\PublishEntityRequest;
use Illuminate\Http\Request;
use App\Entity;
use App\User;

class EntityController extends Controller
{
    public function index(Request $request, string $entity)
    {
        $model = Entity::getChild($entity);
        return response()->json([
            'result' => true,
            'data' => $model::with(['likes', 'owner'])
                ->orderBy('created_at', 'DESC')
                ->paginate(15)
        ]);
    }

    public function entity(Request $request, string $entity, int $entity_id)
    {
        $model = Entity::getChild($entity);
        $entity_data = $model::with(['likes', 'owner'])->findOrFail($entity_id);

        return response()->json([
            'result' => true,
            'data' => $entity_data
        ]);
    }

    public function userEntityList(Request $request, int $user_id, string $entity)
    {
        $user = User::findOrFail($user_id);
        $model = Entity::getChild($entity);

        return response()->json([
            'result' => true,
            'data' => $model::where('user_id', '=', $user->id)
                ->with(['likes', 'owner'])
                ->orderBy('created_at', 'DESC')
                ->paginate(15)
        ]);
    }

    public function publish(PublishEntityRequest $request)
    {
        $model = Entity::getChild($request->entity);
        $entity = new $model();

        $data = $request->only($entity->getFillable());
        $data['user_id'] = $request->user()->id;

        if($request->file('image')) {
            $data['image'] = basename($request->image->store('public/images'));
        }

        foreach ($data as $key => $val) {
            $entity->{$key} = $val;
        }

        try {
            $entity->save();
            return response()->json([
                'result' => true,
                'data' => $entity
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(EditEntityRequest $request){
        $model = Entity::getChild($request->entity);
        $entity = $model::findOrFail($request->id);
        if ($entity->owner->id != $request->user()->id) {
            return abort(403);
        }

        $data = $request->only(['description', 'title', 'body']);

        foreach ($data as $key => $val) {
            $entity->{$key} = $val;
        }

        try {
            $entity->save();
            return response()->json([
                'result' => true,
                'data' => $entity
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'result' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function delete(DeleteEntityRequest $request, string $entity){
        $model = Entity::getChild($entity);
        $entity_model = $model::with('likes')->findOrFail($request->id);

        if($entity_model->user_id == $request->user()->id){
            $entity_model->delete();
            return response()->json([
                'result' => true
            ]);
        } else {
            return abort(403);
        }
    }

    public function like(LikeRequest $request, string $entity, int $entity_id){
        $model = Entity::getChild($entity);
        $entity_model = $model::findOrFail($entity_id);

        if($like = $entity_model->likes()->whereFromUserId($request->user()->id)->first()){
            $like->delete();
        } else {
            $entity_model->likes()->create([
                'entity' => $entity,
                'from_user_id' => $request->user()->id
            ]);
        }

        return response()->json([
            'result' => true,
            'data' => [
                'likes' => $entity_model->likes->count()
            ]
        ]);
    }

}
