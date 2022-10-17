<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\DeleteCommentRequest;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Services\CommentService;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /** @var CommentService */
    private $commentService;

    /**
     * @param CommentService $commentService
     */
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreCommentRequest $request
     * @param $postId
     * @return JsonResponse
     */
    public function store(StoreCommentRequest $request, $postId): JsonResponse
    {
        try {
            $response = $this->commentService->createComment($postId, $request);
            if(!$response){
                return $this->sendError($response, 'Error creating comment, maximum 3 replies per comment.');
            }
            return $this->sendResponse($response, 'Comment created successfully.');

        }catch (\Exception $e){
            return $this->sendError($e->getMessage(), 'Error creating comment, try again later.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCommentRequest $request
     * @param  ?int $postId
     * @param  int $commentId
     * @return JsonResponse
     */
    public function update(UpdateCommentRequest $request, ?int $postId, int $commentId): JsonResponse
    {
        try {
            $response = $this->commentService->updateComment($commentId, $request->name, $request->message);
            return $this->sendResponse($response, 'Comment updated successfully.');

        }catch (\Exception $e){
            return $this->sendError($e->getMessage(), 'Error updating comment, try again later.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteCommentRequest $request
     * @param int|null $postId
     * @param int $commentId
     * @return JsonResponse
     */
    public function destroy(DeleteCommentRequest $request, ?int $postId, int $commentId): JsonResponse
    {
        try {
            $response = $this->commentService->deleteComment($commentId);
            return $this->sendResponse($response, 'Comment deleted successfully.');

        }catch (\Exception $e){
            return $this->sendError($e->getMessage(), 'Error deleted comment, try again later.');
        }
    }
}
