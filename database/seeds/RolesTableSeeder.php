<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        /** @var Role $role **/
        $role = Role::query()->firstOrNew(['name' => 'admin']);
        if (!$role->exists) {
            $role->fill([
                    'display_name' => '管理员',
                ])->save();
        }

        $role = Role::firstOrNew(['name' => 'user']);
        if (!$role->exists) {
            $role->fill([
                    'display_name' => '普通用户',
                ])->save();
        }
    }
}
