<?php

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder{

    public function run(){
        $config = [
            [
                'name'=>'title',
                'value'=>'网站标题'
            ],
            [
                'name'=>'website_record',
                'value'=>'0000001'
            ],
            [
                'name'=>'allow_access',
                'value'=>1
            ],
            [
                'name'=>'seo_key',
                'value'=>'关键字'
            ],
            [
                'name'=>'seo_desc',
                'value'=>'描述'
            ],
            [
                'name'=>'domain',
                'value'=>'macken.me'
            ]
        ];
        DB::table('settings')->insert($config);
    }

}