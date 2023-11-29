<?php

namespace App\Services;

use App\Models\Language;
use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;


class PostService
{
    /**
     * @var PostRepository
     */
    public PostRepository $postRepository;


    /**
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @return Builder[]|Collection
     */
    public function getAllPosts(): Collection|array
    {
      return  $this->postRepository->allPosts();
    }

    public function editPost($postId): Model|Collection|Builder|JsonResponse|array|null
    {
        if ($postId) {
            return $this->postRepository->edit($postId);
        }else{
            return response()-> json([
            'error' => 'Post not found'
        ]);
        }
    }

    /**
     * @param $image
     * @param $languages
     * @return void
     */
    public function postStore($image, $languages)
    {
        if ($image){
            $path = Storage::putFile('public', $image);
        }

        $this->postRepository->store($path, $languages);

    }

    /**
     * @param $id
     * @param $languages
     * @param $image
     * @return void
     */
    public function postUpdate($id, $languages, $image)
    {
         $this->postRepository->update($id, $languages, $image);
    }

    /**
     * @param $id
     * @return void
     */
    public function postDelete($id)
    {
          $this->postRepository->delete($id);

    }


}
