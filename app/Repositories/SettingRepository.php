<?php

namespace App\Http\Repositories;

use App\Setting;
use Illuminate\Http\Request;

/**
 * Class TagRepository
 * @package App\Http\Repository
 */
class SettingRepository extends Repository
{

	static $tag = 'setting';

	/*
	 * cache for one week
	 */
	public function cacheTime()
	{
		return 60 * 24 * 7;
	}

	public function model()
	{
		return app(Setting::class);
	}

	public function getAll()
	{
		$settings = $this->remember('setting.all', function () {
			return Setting::all();
		});
		return $settings;
	}

	public function getByTag($tag)
	{
		$settings = $this->remember('setting.tag.' . $tag, function () use ($tag) {
			return Setting::where('tag', $tag)->get();
		});
		return $settings;
	}

	public function count($tag = null)
	{
		$count = $this->remember('setting.count.' . $tag, function () use ($tag) {
			if ($tag)
				return Setting::where('tag', $tag)->count();
			return Setting::count();
		});
		return $count;
	}

	public function saveSettings(array $inputs)
	{
		foreach ($inputs as $key => $value) {
			$setting = Setting::firstOrNew([
				'key' => $key,
			]);
			$setting->tag = 'settings';
			$setting->value = $value;
			$setting->save();
		}
		$this->clearCache();
	}

	public function getArrayByTag($tag)
	{
		$settings = $this->getByTag($tag);
		$arr = [];
		foreach ($settings as $setting) {
			$arr[$setting->key] = $setting->value;
		}
		return $arr;
	}

	public function get($key)
	{
		$setting = $this->remember('setting.one.' . $key, function () use ($key) {
			return Setting::where('key', $key)->first();
		});
		return $setting;
	}

	public function getValue($key, $default = null)
	{
		$setting = $this->get($key);
		if ($setting && !$setting->value == null && !$setting->value == '')
			return $setting->value;
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
		return Setting::where('key', $key)->delete();
	}

	public function create(Request $request)
	{
		$this->clearCache();
		$setting = Setting::create([
			'key' => $request['key'],
			'value' => $request['value'],
		]);
		return $setting;
	}

	public function tag()
	{
		return SettingRepository::$tag;
	}
}