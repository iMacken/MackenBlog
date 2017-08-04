<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $setting = $this->findSetting('site_title');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => '网站标题',
                'value'        => '网站标题',
                'details'      => '',
                'type'         => 'text',
                'order'        => 1,
            ])->save();
        }

        $setting = $this->findSetting('site_keywords');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => '网站关键字',
                'value'        => '网站关键字',
                'details'      => '',
                'type'         => 'text',
                'order'        => 2,
            ])->save();
        }

        $setting = $this->findSetting('site_description');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => '网站描述',
                'value'        => '网站描述',
                'details'      => '',
                'type'         => 'text',
                'order'        => 3,
            ])->save();
        }

        $setting = $this->findSetting('site_bg_image');
        if (!$setting->exists) {
            $setting->fill([
                'display_name' => '网站背景图片',
                'value'        => '',
                'details'      => '',
                'type'         => 'image',
                'order'        => 9,
            ])->save();
        }
    }



    /**
     * [setting description].
     *
     * @param [type] $key [description]
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function findSetting($key)
    {
        return Setting::query()->firstOrNew(['key' => $key]);
    }
}
