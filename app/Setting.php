<?php
namespace App;

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
        $result = self::select('value')->where('name', $field)->get();
        if (isset($result[0])) {
            return $result[0]->value;
        }
        return false;
    }

}
