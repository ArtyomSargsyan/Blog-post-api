<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;
   // use Translatable;

    //public array $translatedAttributes = ['title', 'content'];

    protected $fillable = [
        'user_id',
        'image'
    ];


    public function languages()
    {
        return $this->belongsToMany(Language::class, 'posts_languages', 'post_id', 'language_id')
            ->withPivot('text');
    }

    public function user()
    {
        return $this->BelongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }



}
