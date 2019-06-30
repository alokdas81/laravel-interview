<?php

namespace App\Infrastructures\Repositories\Eloquent\Contracts;

use Illuminate\Http\Request;

interface ApiRepositoryContract {

    /**
     * Get all records of the resource
     *
     * @param array $columns
     * @return mixed
     */
    public function all($columns = ['*']);

    /**
     * Get a paginated list of resources
     *
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 1, $columns =['*']);

    /**
     * Create a new instance of the resource
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request);

    /**
     * Update a resource by id
     *
     * @param Request $request
     * @param mixed $id
     * @param string $attribute
     * @return mixed
     */
    public function update(Request $request, $id);

    /**
     * Delete a resource by id
     *
     * @param int $id
     * @return mixed
     */
    public function delete($id);

    /**
     * Find a resource by its ID
     *
     * @param int $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*']);

}