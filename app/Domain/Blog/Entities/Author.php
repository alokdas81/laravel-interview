<?php

namespace App\Domain\Blog\Entities;

use App\User;
use App\Domain\Blog\Entities\Category;
use App\Domain\Blog\Entities\Post;

class Author extends User
{
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }
}
