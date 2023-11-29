<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Language;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function response;


class PostController extends Controller
{

    protected PostService $blogService;

    /**
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @return JsonResponse
     */
    public function getAllPost(): JsonResponse
    {

        $posts = $this->postService->getAllPosts();

        return response()->json(['success' => 'all Posts ',
            'posts' => $posts
        ]);
    }


    /**
     * @param PostRequest $request
     * @return JsonResponse
     */
    public function store(PostRequest $request): JsonResponse
    {

        $this->postService->postStore($request->file('image'), $request->input('language'));

        return response()->json(['success'=> 'Post Create']);
    }

    /**
     * @param Post $post
     * @param PostRequest $request
     * @return JsonResponse
     */
    public function edit(Post $post, PostRequest $request): JsonResponse
    {

        $post = $this->postService->editPost($request->segment(4));

        return response()->json(['status' => 200, 'post'=> $post]);

    }

    /**
     * @param PostRequest $request
     * @param Post $post
     * @param $id
     * @return JsonResponse
     */
    public function update(PostRequest $request, Post $post, $id): JsonResponse
    {
        $this->postService->postUpdate($id, $request->input('languages'), $request->input('image'));

        return response()->json(['message' => 'Post updated successfully']);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $this->postService->postDelete($id);

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
