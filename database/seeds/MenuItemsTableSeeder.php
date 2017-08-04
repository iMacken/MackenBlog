<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\MenuItem;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        if (file_exists(base_path('routes/web.php'))) {

            require base_path('routes/web.php');

            $menu = Menu::query()->where('name', 'side_bar')->firstOrFail();

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => '控制台',
                'url'        => route('dashboard'),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-boat',
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => 1,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => '分类',
                'url'        => route('categories.index'),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-categories',
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => 2,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => '菜单',
                'url'        => route('menus.index'),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-list',
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => 3,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => '用户',
                'url'        => route('users.index'),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-person',
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => 13,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => '角色',
                'url'        => route('roles.index'),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-lock',
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => 14,
                ])->save();
            }

            $contentMenuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => '内容',
                'url'        => '',
            ]);
            if (!$contentMenuItem->exists) {
                $contentMenuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-window-list',
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => 16,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => 'Posts',
                'url'        => route('posts.index', [], false),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-news',
                    'color'      => null,
                    'parent_id'  => $contentMenuItem->id,
                    'order'      => 17,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => '页面',
                'url'        => route('pages.index', [], false),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-file-text',
                    'color'      => null,
                    'parent_id'  => $contentMenuItem->id,
                    'order'      => 18,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => '文件',
                'url'        => route('uploaded-files.index', [], false),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-archive',
                    'color'      => null,
                    'parent_id'  => $contentMenuItem->id,
                    'order'      => 20,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => 'Settings',
                'url'        => route('settings.index', [], false),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-settings',
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => 99,
                ])->save();
            }
        }
    }
}
