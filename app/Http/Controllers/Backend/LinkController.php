<?php

namespace App\Http\Controllers\Backend;

use App\Models\Link;

use App\Http\Requests;
use App\Http\Requests\LinkRequest;
use App\Http\Controllers\Controller;
use Notification;

class LinkController extends Controller
{
    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.link.index', [
            'list' => Link::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.link.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LinkRequest $request)
    {
        try {
            if (Link::create($request->all())) {
                Notification::success('添加成功');
                return redirect()->route('backend.link.index');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('backend.link.edit', [
            'link' => Link::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LinkRequest $request, $id)
    {
        //
        try {
            if (Link::find($id)->update($request->all())) {
                Notification::success('修改成功');
            }
            return redirect()->route('backend.link.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Link::destroy($id);
            Notification::success('删除成功');
        } catch (\Exception $e) {
            Notification::error($e->getMessage());
        }


        return redirect()->route('backend.link.index');
    }
}
