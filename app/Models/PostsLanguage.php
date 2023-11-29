<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostsLanguage extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'language_id',
        'text',
        'text_code'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}


