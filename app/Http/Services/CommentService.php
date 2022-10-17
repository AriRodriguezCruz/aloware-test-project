<?php

namespace App\Http\Services;

use App\Http\Repositories\CommentRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class CommentService
{
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    /**
     * CommentService constructor
     *
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param int $postId
     * @param $request
     * @return bool|Model|Builder|object
     */
    public function createComment(int $postId, $request)
    {

        $responseLayer = $this->commentRepository->getLayerFromParent($request->parentId);
        $layer = $responseLayer ? $responseLayer + 1 : 1;

        if ($layer > 3){
            return false;
        }

        return $this->commentRepository->saveComment($request->name,
            $request->message,
            $layer,
            $postId,
            $request->parent);
    }

    /**
     * @param int $commentId
     * @param string $name
     * @param string $message
     * @return Model|Builder|object
     */
    public function updateComment(int $commentId, string $name, string $message)
    {
        return $this->commentRepository->updateComment($commentId, $name, $message);
    }

    /**
     * @param int $commentId
     * @return int
     */
    public function deleteComment(int $commentId): int
    {
        return $this->commentRepository->deleteComment($commentId);
    }

    /**
     * @param int $parentId
     * @return array
     */
    public function getComments(int $parentId): array
    {
        $comments = [];
        foreach ($this->commentRepository->getCommentsByParentId($parentId)->toArray() as $comment) {
            $comments[] = array(
                "id"       => $comment->id,
                "name"     => $comment->name,
                "message"  => $comment->message,
                "comments" => $this->getComments($comment->id)
            );
        }
        return $comments;
    }
}
