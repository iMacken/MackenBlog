<?php namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Input, Redirect, Notification;
use App\Models\Tag;
use App\Http\Requests\TagRequest;

class TagController extends Controller
{

    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tags = Tag::orderBy('id', 'desc')->paginate(10);
        return view('backend.tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(TagRequest $result)
    {
        try {

            if (Tag::create($result->all())) {
                Notification::success('添加成功');
                return redirect()->route('backend.tag.index');
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
    public function edit(Tag $tag)
    {
        return view('backend.tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(TagRequest $result, $id)
    {
        try {

            if (Tag::where('id', $id)->update(['name'=>$result->input('name')])) {

                Notification::success('更新成功');

                return redirect()->route('backend.tag.index');
            }

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
        if (Tag::destroy($id)) {
            Notification::success('删除成功');
        } else {
            Notification::error('删除失败');
        }
        return redirect()->route('backend.tag.index');
    }

    public function getTags(Request $request)
    {
        $search = $request->input('search');
        return Tag::where('name', 'like', '%' . $search . '%')->paginate(10);
    }

}
