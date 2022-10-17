<?php

namespace App\Http\Services;

use App\Http\Repositories\PostRepository;
use App\Http\Repositories\CommentRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class PostService
{
    /**
     * @var PostRepository
     * @var CommentService
     * @var CommentRepository
     */
    private $postRepository;
    private $commentService;
    private $commentRepository;

    /**
     * PostService constructor
     *
     * @param PostRepository $postRepository
     * @param CommentService $commentService
     * @param CommentRepository $commentRepository
     */
    public function __construct(PostRepository $postRepository, CommentService $commentService, CommentRepository $commentRepository)
    {
        $this->postRepository = $postRepository;
        $this->commentService = $commentService;
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param int $postId
     * @return Model|Builder|object|null
     */
    public function getPost(int $postId)
    {
        $post = $this->postRepository->getPost($postId);
        $commentsPost = $this->commentRepository->getCommentsByPostId($postId)->toArray();
        foreach ($commentsPost as $comment){
            $post->comments = $this->commentService->getComments($comment->id);
        }
        return $post;
    }
}
