<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenusTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        Menu::query()->firstOrCreate([
            'name' => 'side_bar',
            'display_name' => '侧边栏导航'
        ]);
    }
}
