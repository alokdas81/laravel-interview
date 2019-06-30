<?php

namespace App\Domain\Blog\Repositories;

use App\Domain\Blog\Entities\Category;
use App\Infrastructures\Repositories\Eloquent\Abstractions\ApiRepositoryAbstraction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CategoryRepository extends ApiRepositoryAbstraction
{
    /**
     * Specify the eloquent model
     *
     * @return mixed
     */
    function model()
    {
        return Category::class;
    }

    /**
     * Validate the request data
     *
     * @return void
     */
    protected function validation(Request $request, $id = null)
    {
        $rules = [
            'parent_category' => ['sometimes', 'nullable', 'exists:categories,id'],
            'title' => ['required', Rule::unique('categories')->ignore($id)],
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
        $this->model->parent_category_id = $request->parent_category;
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
