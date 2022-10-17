<?php

namespace App\Http\Repositories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CommentRepository extends BaseRepository
{
    /**
     * Gets the base model for the repository
     *
     * @return Model
     */
    public function getModel(): Model
    {
        return new Comment();
    }

    /**
     * @param $id
     * @return Model|Builder|object|null
     */
    public function getCommentById($id){
        return DB::table('comments')
            ->where('id', $id)
            ->select([
                'post_id',
                'parent_id',
                'name',
                'message',
                'layer',
            ])->first();
    }

    /**
     * @param string $name
     * @param string $message
     * @param int $layer
     * @param int|null $postId
     * @param int|null $parentId
     * @return Builder|Model|object
     */
    public function saveComment(string $name, string $message, int $layer, ?int $postId, ?int $parentId)
    {
        $id = DB::table('comments')->insertGetId([
            'post_id' => $postId,
            'parent_id' => $parentId,
            'name' => $name,
            'message' => $message,
            'layer' => $layer,
        ]);

        return $this->getCommentById($id);

    }

    /**
     * @param int $commentId
     * @param string $name
     * @param string $message
     * @return Model|Builder|object|null
     */
    public function updateComment(int $commentId, string $name, string $message)
    {
        DB::table('comments')
            ->where('id', $commentId)
            ->update(['name' => $name, 'message' => $message]);

        return $this->getCommentById($commentId);
    }

    /**
     * @param int $commentId
     * @return int
     */
    public function deleteComment(int $commentId): int
    {
        return DB::table('comments')
            ->where('id', $commentId)
            ->update(['deleted_at' => date("Y-m-d H:i:s")]);
    }

    /**
     * @param int $postId
     * @return Collection
     */
    public function getCommentsByPostId(int $postId): Collection
    {
        return DB::table('comments')
            ->where('post_id', $postId)
            ->get();
    }


    /**
     * @param int $parentId
     * @return Collection
     */
    public function getCommentsByParentId(int $parentId): Collection
    {
        return DB::table('comments')
            ->where('parent_id', $parentId)
            ->where('layer', '<',4)
            ->get();
    }

    /**
     * @param int $parentId
     * @return mixed
     */
    public function getLayerFromParent(int $parentId){
        return DB::table('comments')
            ->where('id', $parentId)
            ->pluck('layer')->first();
    }
}
