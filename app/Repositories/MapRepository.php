<?php

namespace App\Repositories;

use App\Map;
use Illuminate\Http\Request;

/**
 * Class TagRepository
 * @package App\Http\Repository
 */
class MapRepository extends Repository
{

    static $tag = 'map';

    /*
     * cache for one week
     */
    public function cacheTime()
    {
        return 60 * 24 * 7;
    }

    public function model()
    {
        return app(Map::class);
    }

    public function getAll()
    {
        $maps = $this->remember('map.all', function () {
            return Map::all();
        });
        return $maps;
    }

    public function getByTag($tag)
    {
        $maps = $this->remember('map.tag.' . $tag, function () use ($tag) {
            return Map::where('tag', $tag)->get();
        });
        return $maps;
    }

    public function count($tag = null)
    {
        $count = $this->remember('map.count.' . $tag, function () use ($tag) {
            if ($tag) {
                return Map::where('tag', $tag)->count();
            }
            return Map::count();
        });
        return $count;
    }

    public function save(array $inputs, $tag = 'setting')
    {
        foreach ($inputs as $key => $value) {
            /** @var Map $map */
            $map = Map::firstOrNew(['key' => $key]);
            $map->tag = $tag;
            $map->value = $value;
            $map->save();
        }
        $this->clearCache();
    }

    public function getArrayByTag($tag)
    {
        $maps = $this->getByTag($tag);
        $arr = [];
        foreach ($maps as $map) {
            $arr[$map->key] = $map->value;
        }
        return $arr;
    }

    public function get($key)
    {
        $map = $this->remember('map.one.' . $key, function () use ($key) {
            return Map::where('key', $key)->first();
        });
        return $map;
    }

    public function getValue($key, $default = null)
    {
        $map = $this->get($key);
        if ($map && !$map->value == null && !$map->value == '')
            return $map->value;
        return $default;
    }

    public function getBoolValue($key, $default = false)
    {
        $defaultValue = $default ? 'true' : 'false';
        return $this->getValue($key, $defaultValue) == 'true';
    }

    public function delete($key)
    {
        $this->clearCache();
        return Map::where('key', $key)->delete();
    }

    public function create(Request $request)
    {
        $this->clearCache();
        $map = Map::create([
            'key' => $request['key'],
            'value' => $request['value'],
        ]);
        return $map;
    }

    public function tag()
    {
        return MapRepository::$tag;
    }
}