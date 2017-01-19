<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password','photo'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    static $users = [];

    public function articles() {
       return $this->hasMany('App\Article', 'user_id', 'id');
    }

    public static function getUserInfoModelByUserId($userId){
        return self::select('id','name','email','photo','desc')->find($userId);
    }

    public static function getUserArr($userId){

        if(!isset(self::$users[$userId])){
            $user = self::select('name')->find($userId)->toArray();
            if(empty($user)){
                return false;
            }
            self::$users[$userId] = $user['name'];
        }

        return self::$users[$userId];
    }

    public static function getUserNameByUserId($userId){

        $userName = self::getUserArr($userId);

        return !empty($userName)?$userName:'用户不存在';

    }

    /**
     * 更新用户
     * @param $id
     * @param $request
     * @return bool
     */
    public static function updateUserInfo($id,$request){

        if(!empty($id) && !empty($request)){

            $user = self::find($id);
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            if(!empty($request->input('password'))) {
                $user->password = bcrypt($request->input('password'));
            }
            $photo = upload_file('photo', $request);
            if(!empty($photo)){
                $user->photo = $photo;
            }

            return $user->save();
        }
        return false;
    }
}
