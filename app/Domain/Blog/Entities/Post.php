<?php

namespace App\Domain\Blog\Entities;

use App\Domain\Blog\Entities\Author;
use App\Domain\Blog\Entities\Category;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
