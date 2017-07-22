<?php

namespace App\Repositories;

/**
 * This is the slug repository trait.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
trait SlugRepositoryTrait
{
    /**
     * Find an existing model by slug.
     *
     * @param string   $slug
     * @param string[] $columns
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($slug, array $columns = ['*'])
    {
        $model = $this->model;

        return $model::where('slug', '=', $slug)->first($columns);
    }
}
