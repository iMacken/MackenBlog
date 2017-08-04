<?php

namespace App\Http\Controllers;

use App\Facades\Toastr;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function index()
    {
        return view('setting.index');
    }

    public function save(Request $request)
    {
        $inputs = $request->except(['_token','_url']);
        $this->settingRepository->save($inputs, 'setting');
        Toastr::success('保存成功');
        return back();
    }
}
