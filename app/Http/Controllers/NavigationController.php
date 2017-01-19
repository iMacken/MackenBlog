<?php namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Navigation;
use App\Http\Requests\NavigationRequest;
use Notification;

class NavigationController extends Controller
{

    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function list()
    {
        $list = Navigation::getNavigationAll();
        return view('navigation.list', compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('navigation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(NavigationRequest $request)
    {

        try {
            if (Navigation::create($request->all())) {
                Notification::success('添加成功');
                return redirect()->route('navigation.list');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('navigation.edit', [
            'navigation' => Navigation::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(NavigationRequest $request, $id)
    {

        try {
            if (Navigation::find($id)->update($request->all())) {
                Notification::success('修改成功');
            }
            return redirect()->route('navigation.list');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(array('error' => $e->getMessage()))->withInput();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {

        try {
            Navigation::destroy($id);
            Notification::success('删除成功');
        } catch (\Exception $e) {
            Notification::error($e->getMessage());
        }


        return redirect()->route('navigation.list');
    }

}
