<?php

namespace App\Models;

use App\Traits\FollowTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use SoftDeletes, Notifiable, FollowTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'is_admin', 'avatar', 'password', 'confirm_code',
        'nickname', 'real_name', 'email_notify_enabled', 'website', 'description', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'confirm_code', 'updated_at', 'deleted_at'
    ];

    static $users = [];

    public function articles() {
       return $this->hasMany('App\Article', 'user_id', 'id');
    }

    public function isSuperAdmin() {
        return $this->id === 1;
    }

	public function isAdmin()
	{
		return !!$this->is_admin;
	}

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

}
