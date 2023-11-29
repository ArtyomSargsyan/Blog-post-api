<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function response;

class CommentController extends Controller
{
    protected CommentService $commentService;

    /**
     * @param CommentService $commentService
     */
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * @param CommentRequest $request
     * @return JsonResponse
     */
    public function index(CommentRequest $request): JsonResponse
    {

       $comments =   $this->commentService->getPostComments($request->segment(4));

        return response()->json(['get Post Comments',  'comments'=> $comments]);
    }


    /**
     * @param CommentRequest $request
     * @return JsonResponse
     */
    public function store(CommentRequest $request): JsonResponse
    {

       $this->commentService->commentStore($request->segment(4), Auth::user()->id, $request->input('content'));

       return response()->json(['success' => 'comment created successfully']);
    }

    /**
     * @param CommentRequest $comment
     * @param Request $request
     * @return JsonResponse
     */
    public function edit(CommentRequest $comment, Request $request): JsonResponse
    {

        $comment = $this->commentService->commentEdit($request->segment(4));

        return response()->json(['success' => 'edit comment', 'comment'=>$comment]);

    }

    /**
     * @param CommentRequest $request
     * @param Comment $comment
     * @return JsonResponse
     */
    public function update(CommentRequest $request, Comment $comment): JsonResponse
    {

        $this->commentService->commentUpdate($request->segment(4), $request->input('content'));

       return response()->json(['success' => 'comment updated successfully']);
    }

    /**
     * @param Comment $comment
     * @param $id
     * @return JsonResponse
     */
    public function destroy(Comment $comment, $id)
    {
        $this->commentService->commentDelete($id);

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
