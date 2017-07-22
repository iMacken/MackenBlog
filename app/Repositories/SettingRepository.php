<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository
{
    use BaseRepositoryTrait;

    public function save(array $inputs)
    {
        foreach ($inputs as $key => $value) {
            /** @var Setting $setting */
            $setting = Setting::query()->firstOrNew(['key' => $key]);
            $setting->value = $value;
            $setting->save();
        }
    }

    public function get($key)
    {
        return Setting::query()->where('key', $key)->first();
    }

    public function getValue($key, $default = null)
    {
        $setting = $this->get($key);
        if ($setting && !$setting->value == null && !$setting->value == '')
            return $setting->value;
        return $default;
    }
}
