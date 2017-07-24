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

            $menu = Menu::where('name', 'side_bar')->firstOrFail();

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
                'url'        => route('categories.index', ['type' => 'admin']),
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

            $organizationMenuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => 'Organization',
                'url'        => '',
            ]);
            if (!$organizationMenuItem->exists) {
                $organizationMenuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-company',
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => 12,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => 'Users',
                'url'        => route('admin.users.index', [], false),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-person',
                    'color'      => null,
                    'parent_id'  => $organizationMenuItem->id,
                    'order'      => 13,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => 'Roles',
                'url'        => route('admin.roles.index', [], false),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-lock',
                    'color'      => null,
                    'parent_id'  => $organizationMenuItem->id,
                    'order'      => 14,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => 'Departments',
                'url'        => route('admin.departments.index', [], false),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-group',
                    'color'      => null,
                    'parent_id'  => $organizationMenuItem->id,
                    'order'      => 15,
                ])->save();
            }

            $contentMenuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => 'Content',
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
                'url'        => route('admin.posts.index', [], false),
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
                'title'      => 'Pages',
                'url'        => route('admin.pages.index', [], false),
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
                'title'      => 'Videos',
                'url'        => route('admin.videos.index', [], false),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-video',
                    'color'      => null,
                    'parent_id'  => $contentMenuItem->id,
                    'order'      => 19,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => 'Pictures',
                'url'        => route('admin.pictures.index', [], false),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-photos',
                    'color'      => null,
                    'parent_id'  => $contentMenuItem->id,
                    'order'      => 20,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => 'Friend Links',
                'url'        => route('admin.friend-links.index', [], false),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-heart',
                    'color'      => null,
                    'parent_id'  => $contentMenuItem->id,
                    'order'      => 21,
                ])->save();
            }

            $recruitMenuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => 'Recruit',
                'url'        => '',
            ]);
            if (!$recruitMenuItem->exists) {
                $recruitMenuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-magnet',
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => 25,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => 'Position Admin',
                'url'        => route('admin.positions.index', [], false),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-thumb-tack',
                    'color'      => null,
                    'parent_id'  => $recruitMenuItem->id,
                    'order'      => 26,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => 'Position Application',
                'url'        => route('admin.position-applications.index', [], false),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-mail',
                    'color'      => null,
                    'parent_id'  => $recruitMenuItem->id,
                    'order'      => 27,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => 'Interview',
                'url'        => route('admin.interviews.index', [], false),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-chat',
                    'color'      => null,
                    'parent_id'  => $recruitMenuItem->id,
                    'order'      => 28,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => 'Interview Schedules',
                'url'        => route('admin.interview-schedules.index', [], false),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-alarm-clock',
                    'color'      => null,
                    'parent_id'  => $recruitMenuItem->id,
                    'order'      => 29,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => 'Staff Shares',
                'url'        => route('admin.staff-shares.index', [], false),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => 'voyager-trophy',
                    'color'      => null,
                    'parent_id'  => $recruitMenuItem->id,
                    'order'      => 30,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => 'Settings',
                'url'        => route('admin.settings.index', [], false),
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



            $menu = Menu::where('name', 'top_nav')->firstOrFail();

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => '首页',
                'url'        => route('home'),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => '',
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => 1,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => '公司简介',
                'url'        => url('#about-us'),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => '',
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => 2,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => '岗位招聘',
                'url'        => url('#recruit'),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => '',
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => 3,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => '招聘行程',
                'url'        => url('#recruit-schedule'),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => '',
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => 4,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => '往届分享',
                'url'        => url('#staff-shares'),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => '',
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => 5,
                ])->save();
            }

            $menuItem = MenuItem::query()->firstOrNew([
                'menu_id'    => $menu->id,
                'title'      => '吉社生活',
                'url'        => url('#jishe-life'),
            ]);
            if (!$menuItem->exists) {
                $menuItem->fill([
                    'target'     => '_self',
                    'icon_class' => '',
                    'color'      => null,
                    'parent_id'  => null,
                    'order'      => 6,
                ])->save();
            }

        }
    }
}
