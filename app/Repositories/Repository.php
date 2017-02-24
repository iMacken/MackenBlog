<?php

namespace App\Repositories;

use App\Services\BlogCache;
use Closure;

abstract class Repository
{
    /**
     * @var BlogCache
     */
    private $blogCache;

    public abstract function model();

    public abstract function tag();

    private function getBlogCache()
    {
        if ($this->blogCache == null) {
            $this->blogCache = app('BlogCache');
            $this->blogCache->setTag($this->tag());
            $this->blogCache->setTime($this->cacheTime());
        }
        return $this->blogCache;
    }

    public function cacheTime()
    {
        return 60;
    }

    public function count()
    {
        $count = $this->remember($this->tag() . '.count', function () {
            return $this->model()->count();
        });
        return $count;
    }

    public function all()
    {
        $all = $this->remember($this->tag() . '.all', function () {
            return $this->model()->all();
        });
        return $all;
    }

    public function remember($key, Closure $entity, $tag = null)
    {
        return $this->getBlogCache()->remember($key, $entity, $tag);
    }

    public function forget($key, $tag = null)
    {
        $this->getBlogCache()->forget($key, $tag);
    }

    public function clearCache($tag = null)
    {
        $this->getBlogCache()->clearCache($tag);
    }

    public function clearAllCache()
    {
        $this->getBlogCache()->clearAllCache();
    }

}