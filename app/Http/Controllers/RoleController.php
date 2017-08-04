<?php

namespace App\Http\Controllers;

use App\Facades\Toastr;
use Illuminate\Http\Request;
use App\Facades\Admin;

class RoleController extends Controller
{
    public function update(Request $request, $id)
    {

        $slug = $this->getSlug($request);

        $dataType = Admin::model('DataType')->where('slug', '=', $slug)->first();

        //Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->addRows);

        if ($val->fails()) {
            return response()->json(['errors' => $val->messages()]);
        }

        if (!$request->ajax()) {
            $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);
            $this->insertUpdateData($request, $slug, $dataType->editRows, $data);

            $data->permissions()->sync($request->input('permissions', []));

            Toastr::success(__('Successfully Updated') . $dataType->display_name_singular);

            return redirect()->route("admin.{$dataType->slug}.index");
        }
    }

    public function store(Request $request)
    {
        Admin::canOrFail('add_roles');

        $slug = $this->getSlug($request);

        $dataType = Admin::model('DataType')->where('slug', '=', $slug)->first();

        //Validate fields with ajax
        $val = $this->validateBread($request->all(), $dataType->addRows);

        if ($val->fails()) {
            return response()->json(['errors' => $val->messages()]);
        }

        if (!$request->ajax()) {
            $data = new $dataType->model_name();
            $this->insertUpdateData($request, $slug, $dataType->addRows, $data);

            $data->permissions()->sync($request->input('permissions', []));

            Toastr::success(__('Successfully Added New') . $dataType->display_name_singular);

            return redirect()->route("admin.{$dataType->slug}.index");
        }
    }
}
