<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth, Input;

class Setting extends Model
{

    public $timestamps = false;

    protected $fillable = array(
        'name',
        'value'
    );

    /**
     * 获取指定配置值
     * @param $field
     * @return mixed
     */
    public function getSetting($field)
    {
        return self::select('value')->where('name', $field)->pluck('value')[0];
    }

}
