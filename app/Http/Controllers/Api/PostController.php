<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\GetPostRequest;
use App\Http\Services\PostService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class PostController extends Controller
{
    /** @var PostService */
    private $postService;

    /**
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @param GetPostRequest $request
     * @param $postId
     * @return Model|Builder|object|null
     */
    public function show(GetPostRequest $request, $postId)
    {
        return $this->postService->getPost($postId);
    }
}
