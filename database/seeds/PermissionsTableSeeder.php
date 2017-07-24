<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $keys = [
            'browse_dashboard',
            'browse_settings',
        ];

        foreach ($keys as $key) {
            Permission::query()->firstOrCreate([
                'key'        => $key,
                'table_name' => null,
            ]);
        }

        Permission::generateFor('menus');

        Permission::generateFor('categories');

        Permission::generateFor('roles');

        Permission::generateFor('users');

        Permission::generateFor('posts');

        Permission::generateFor('pages');
    }
}
