<?php

namespace App\Http\Controllers;

use App\Facades\Toastr;
use App\Repositories\MapRepository;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    protected $mapRepository;

    public function __construct(MapRepository $mapRepository)
    {
        $this->mapRepository = $mapRepository;
    }

    public function index()
    {
        return view('setting.index');
    }

    public function save(Request $request)
    {
        $inputs = $request->except(['_token','_url']);
        $this->mapRepository->save($inputs, 'setting');
        Toastr::success('保存成功');
        return back();
    }
}
