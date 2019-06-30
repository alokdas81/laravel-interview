<?php

namespace App\Domain\Blog\Repositories;

use App\Domain\Blog\Entities\Post;
use App\Infrastructures\Repositories\Eloquent\Abstractions\ApiRepositoryAbstraction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PostRepository extends ApiRepositoryAbstraction
{
    /**
     * Specify the eloquent model
     *
     * @return mixed
     */
    function model()
    {
        return Post::class;
    }

    /**
     * Validate the request data
     *
     * @return void
     */
    protected function validation(Request $request, $id = null)
    {
        $rules = [
            'category' => ['required', 'exists:categories,id'],
            'title' => ['required', Rule::unique('posts')->ignore($id)],
            'description' => ['sometimes', 'nullable'],
            'image' => ['sometimes', 'file', 'image'],
        ];
        $request->validate($rules);
        return $this;
    }

    /**
     * Set the properties
     *
     * @return void
     */
    protected function setAttributes(Request $request)
    {
        $this->model->author_id = $request->user()->id;
        $this->model->category_id = $request->category;
        $this->model->title = $request->title;
        $this->model->slug = Str::slug($request->title);
        $this->model->description = $request->description;
        $this->model->is_active = !empty($request->is_active) ? true : null;
        $this->model->save();
        return $this;
    }

    /**
     * Specify model image attributes
     *
     * @return array
     */
    protected function images()
    {
        return ['image'];
    }
}
