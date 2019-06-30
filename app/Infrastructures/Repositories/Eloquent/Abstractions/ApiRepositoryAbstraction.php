<?php

namespace App\Infrastructures\Repositories\Eloquent\Abstractions;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Container\Container as App;
use App\Infrastructures\Repositories\Eloquent\Contracts\ApiRepositoryContract;
use App\Infrastructures\Repositories\Eloquent\Exceptions\ApiRepositoryException;
use App\Infrastructures\Repositories\Criteria\Criteria;
use Illuminate\Support\Str;
use Storage;

abstract class ApiRepositoryAbstraction implements ApiRepositoryContract
{
    /**
     * @var App
     */
    private $app;

    /**
     * The core eloquent model
     *
     * @var $model
     */
    protected $model;

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public abstract function model();

    /**
     * Set the model attributes
     *
     * @return this
     */
    protected abstract function setAttributes(Request $request);

    /**
     * Validate the incoming form data
     *
     * @return mixed
     */
    protected abstract function validation(Request $request, $id = null);

    /**
     * Specify model image attributes
     *
     * @return array
     */
    protected abstract function images();

    /**
     * @param App $app
     * @param Collection $collection
     * @throws \Bosnadev\Repositories\Exceptions\RepositoryException
     */
    public function __construct(App $app, Collection $collection)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Get all resources
     *
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        return $this->model->get($columns);
    }

    /**
     * Get a paginated list of resources
     *
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = ['*'])
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * Load relations
     *
     * @param array $relations
     * @return $this
     */
    public function load(array $relations)
    {
        return $this->model->load($relations);
    }

    /**
     * Create a new instance of the resource
     *
     * @param array $data
     * @return mixed
     */
    public function create(Request $request)
    {
        $this->validation($request)->setAttributes($request)->saveImages($request);
        return $this->model;
    }

    /**
     * Update the attributes of the resource
     *
     * @param array $data
     * @param mixed $id
     * @param string $attribute
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $this->find($id);
        $this->validation($request, $id)->setAttributes($request)->saveImages($request);
        return $this->model;
    }

    /**
     * Delete a resource by id
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * Find a resource by its ID
     *
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        $this->model = $this->model->findOrFail($id, $columns);
        return $this->model;
    }

    /**
     * Try and set the model instance
     *
     * @return \Illuminate\Database\Eloquent\Builder
     * @throws RepositoryException
     */
    public function makeModel()
    {
        return $this->setModel($this->model());
    }

    /**
     * Set Eloquent Model to instantiate
     *
     * @param Illuminate\\Database\\Eloquent\\Model $model
     * @return Model
     * @throws ApiRepositoryException
     */
    protected function setModel($model)
    {
        $eloquent_model = $this->app->make($model);
        if (!$eloquent_model instanceof Model) {
            throw new ApiRepositoryException("Class {$eloquent_model} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        return $this->model = $eloquent_model;
    }

    /**
     * Set Eloquent Model to instantiate
     *
     * @param Illuminate\\Database\\Eloquent\\Model $model
     * @return
     */
    protected function saveImages(Request $request)
    {
        foreach ($this->images() as $attribute) {
            if ($request->hasFile($attribute)) {
                Storage::disk('public')->delete($this->model->$attribute);
                $directory = Str::plural($attribute);
                $this->model->$attribute = $request->image->store("uploads/blog/{$directory}", 'public');
                $this->model->save();
            }
        }
        return $this;
    }

}