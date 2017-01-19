<?php namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Setting;
use App\Http\Requests\SettingRequest;
use Input, Redirect, Notification;
use Request;

class SettingController extends Controller
{

    public function __construct()
    {

    }


    public function list()
    {

        return view('setting.list', ['setting' => Setting::all()]);
    }

    public function save()
    {
        $setting = Request::get('setting');
        if (!empty($setting)) {
            foreach ($setting as $k => $v) {
                Setting::where('name', '=', $k)->update(['value' => $v]);
            }
            Notification::success('保存成功');
            return redirect()->back();
        }
        Notification::success('保存失败');
        return redirect()->back();
    }


}
