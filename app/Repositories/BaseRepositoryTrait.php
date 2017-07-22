<?php

namespace App\Repositories;

trait BaseRepositoryTrait
{
    /**
     * Create a new model.
     *
     * @param array $input
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $input)
    {
        $model = $this->model;

        return $model::create($input);
    }

    /**
     * Find an existing model.
     *
     * @param int      $id
     * @param string[] $columns
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($id, array $columns = ['*'])
    {
        $model = $this->model;

        return $model::find($id, $columns);
    }

    /**
     * Find all models.
     *
     * @param string[] $columns
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(array $columns = ['*'])
    {
        $model = $this->model;

        return $model::all($columns);
    }

    /**
     * Get a list of the models.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        $model = $this->model;

        if (property_exists($model, 'order')) {
            return $model::orderBy($model::$order, $model::$sort)->get($model::$index);
        }

        return $model::get($model::$index);
    }

    /**
     * Get the number of rows.
     *
     * @return int
     */
    public function count()
    {
        $model = $this->model;

        return $model::where('id', '>=', 1)->count();
    }

    /**
     * Register an observer.
     *
     * @param object $observer
     *
     * @return $this
     */
    public function observe($observer)
    {
        $model = $this->model;
        $model::observe($observer);

        return $this;
    }
}
