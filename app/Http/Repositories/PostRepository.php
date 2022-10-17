<?php

namespace App\Http\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class PostRepository extends BaseRepository
{
    /**
     * Gets the base model for the repository
     *
     * @return Model
     */
    public function getModel(): Model
    {
        return new Post();
    }

    /**
     * @param int $postId
     * @return Model|Builder|object|null
     */
    public function getPost(int $postId)
    {
        return DB::table('posts')
            ->where('id', $postId)
            ->select(['title', 'text'])
            ->first();
    }
}
