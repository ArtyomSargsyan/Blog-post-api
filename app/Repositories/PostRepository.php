<?php

namespace App\Repositories;
use App\Models\Language;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PostRepository  implements  PostRepositoryInterface
{

    /**
     * @var Post
     */
    public Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }


    /**
     * @return Builder[]|Collection
     */
    public function allPosts(): Collection|array
    {

        $language = Language::where('code', app()->getLocale())->firstOrFail();

          return  Post::with(['languages' => function ($query) use ($language) {
                $query->where('language_id', $language->id);
            }])->get();
    }

    /**
     * @param $postId
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function edit($postId)
    {
        $language = Language::where('code', app()->getLocale())->firstOrFail();

       return  Post::with(['languages' => function ($query) use ($language) {
            $query->where('language_id', $language->id);
        }])->find($postId);
    }

    /**
     * @param $path
     * @param $languages
     * @return void
     */
    public function store($path, $languages)
    {
        $post = new Post();
        $post->image = $path;
        $post->user_id = auth()->user()->id;

        $post->save();

        foreach ($languages as $language) {
            $langModel = Language::where('code', $language['code'])->firstOrFail();

            $post->languages()->attach($langModel->id, ['text' => $language['text']]);
        }
    }

    /**
     * @param $id
     * @param $languages
     * @param $image
     * @return void
     */
    public function update($id, $languages, $image)
    {
        $post = Post::findOrFail($id);

        $post->image = $image;
        $post->save();

        foreach ($languages as $language) {
            $langModel = Language::where('code', $language['code'])->firstOrFail();
            $post->languages()->syncWithoutDetaching([$langModel->id => ['text' => $language['text']]]);
        }
    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        $post = Post::findOrFail($id);

        if ($post->image) {
            Storage::store('public/image')->delete($post->image);
        }
        $post->delete();
    }


}
