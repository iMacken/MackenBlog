<?php namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Setting;
use App\Http\Requests\SettingRequest;
use Input, Redirect, Notification;
use Request;

class SettingController extends Controller
{

    public function __construct()
    {

    }


    public function index()
    {

        return view('backend.setting.index', ['setting' => Setting::all()]);
    }

    public function create()
    {
        return view('backend.setting.create');
    }

    public function store(SettingRequest $result)
    {

        try {
            if (Setting::create($result->all())) {
                Notification::success('添加成功,请修改语言包文件');
                return redirect('backend/setting/index');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }

    }

    public function destroy($id)
    {
        if (Setting::destroy($id)) {
            Notification::success('删除成功');
        } else {
            Notification::success('删除失败');
        }

        return redirect()->back();
    }

    public function postStore()
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
