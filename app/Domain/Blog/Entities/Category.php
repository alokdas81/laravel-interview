<?php

namespace App\Domain\Blog\Entities;

use App\Domain\Blog\Entities\Category;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function parent_category()
    {
        return $this->belongsTo(Category::class);
    }
}
