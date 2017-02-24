<?php
namespace App\Services;

use Closure;

class BlogCache
{
    public $tag;

    public $cacheTime;

    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    public function remember($key, Closure $entity, $tag = null)
    {
        return cache()->tags($tag == null ? $this->tag : $tag)->remember($key, $this->cacheTime, $entity);
    }


    public function forget($key, $tag = null)
    {
        cache()->tags($tag == null ? $this->tag : $tag)->forget($key);
    }

    public function clearCache($tag = null)
    {
        cache()->tags($tag == null ? $this->tag : $tag)->flush();
    }

    public function clearAllCache()
    {
        cache()->flush();
    }

    public function setTime($time_in_minute)
    {
        $this->cacheTime = $time_in_minute;
    }
}