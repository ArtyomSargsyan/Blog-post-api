<?php

namespace App\Services;

use App\Repositories\CommentRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Ramsey\Uuid\Type\Integer;


class CommentService
{
    /**
     * @var CommentRepository
     */

    protected CommentRepository $commentRepository;


    /**
     * @param CommentRepository $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param $postId
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function getPostComments($postId)
    {
      return  $this->commentRepository->getComments($postId);
    }


    /**
     * @param $postId
     * @param $userId
     * @param $content
     * @return void
     */
    public function commentStore($postId, $userId, $content)
    {
        $this->commentRepository->store($postId, $userId, $content);
    }

    /**
     * @param $commentId
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function commentEdit($commentId): Model|Collection|Builder|array|null
    {
       return $this->commentRepository->edit($commentId);
    }

    /**
     * @param $commentId
     * @param $content
     * @return void
     */
    public function commentUpdate($commentId, $content)
    {
       $this->commentRepository->update($commentId, $content);
    }

    /**
     * @param $id
     * @return JsonResponse|void
     */
    public function commentDelete($id)
    {
        if ($id) {
            $this->commentRepository->delete($id);
        } else{
            return response()->json(['status', 404]);
        }
    }

}
