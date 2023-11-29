<?php

namespace App\Repositories;

use App\Models\CommentsLanguage;
use App\Models\Language;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class CommentRepository  implements  CommentRepositoryInterface
{

    /**
     * @var Comment
     */
    protected Comment $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function getComments($postId)
    {
        $language = Language::where('code', app()->getLocale())->firstOrFail();

        return Post::with(['languages' => function ($query) use ($language) {
            $query->where('language_id', $language->id);
        }, 'comments.languages' => function ($query) use ($language) {
            $query->where('language_id', $language->id);
        }])->find($postId);
    }

    public function store($postId, $userId, $content)
    {
        $comment = Comment::create([
            'post_id' => $postId,
            'user_id' => $userId,
        ]);
        $lang =  Language::where('code', app()->getLocale())->firstOrFail();
        $commentLanguage = new CommentsLanguage();
        $commentLanguage->comment_id = $comment->id;
        $commentLanguage->language_id = $lang->id;
        $commentLanguage->content =  $content;
        $commentLanguage->save();
    }

    public function edit($commentId): Model|Collection|Builder|array|null
    {
        $language = Language::where('code', app()->getLocale())->firstOrFail();

        return Comment::with(['languages' => function ($query) use ($language) {
            $query->where('language_id', $language->id);
        }])->find($commentId);
    }

    public function update($commentId, $content)
    {
        $language = Language::where('code', app()->getLocale())->firstOrFail();

        $commentLanguage = CommentsLanguage::where('comment_id', $commentId)
            ->where('language_id', $language->id)
            ->first();

        if (!$commentLanguage) {
            return response()->json(['message' => 'Comment language not found'], 404);
        }

        $commentLanguage->content = $content;
        $commentLanguage->save();
    }


    public function delete($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
    }

}
