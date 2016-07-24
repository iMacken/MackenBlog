<?php

use Illuminate\Database\Seeder;
use App\Services\Registrar;
class UserSeeder extends Seeder{
    public function run(){
        $data = [
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' =>'asdasd',
        ];
        $register = new Registrar();
        $register->create($data);
    }
}