<?php

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::query()->count() == 0) {
            $role = Role::query()->where('name', 'admin')->firstOrFail();
            User::query()->create([
                'name'           => '超级管理员',
                'email'          => 'admin@admin.com',
                'phone'          => '13388889999',
                'password'       => bcrypt('password'),
                'remember_token' => str_random(60),
                'role_id'        => $role->id,
            ]);
        }
    }
}
