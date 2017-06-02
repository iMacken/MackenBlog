<?php

namespace App\Http\Controllers;

use App\Facades\BlogConfig;
use App\Facades\Toastr;
use App\Http\Requests;

use App\Repositories\UserRepository;
use App\Services\Registrar;
use App\User;
use Illuminate\Http\Response;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('user.index', ['users' => User::orderBy('id', 'desc')->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        if ($this->userRepository->create($request->all())) {
	        Toastr::success('用户创建成功');
	        return redirect()->route('user.index');
        }
	    Toastr::success('用户创建失败');

	    return redirect()->back()->withInput();
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
     * @param  User $user
     * @return Response
     */
    public function edit(User $user)
    {
        return view('user.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param  UserRequest $request
     * @return Response
     */
    public function update($id, UserRequest $request)
    {
        $this->authorize('update', $this->userRepository->getById($id));

	    $result = $this->userRepository->update($id, $request->all());

	    if ($result) {
		    Toastr::success('用户更新成功');
		    return redirect()->route('user.edit', ['id' => $id]);
	    }
	    Toastr::error('用户更新失败');

	    return redirect()->back()->withInput();;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', $this->userRepository->getById($id));

	    $result = $this->userRepository->delete($id);

	    if ($result) {
		    Toastr::success('用户删除成功');
		    return redirect()->route('user.index');
	    }
	    Toastr::error('用户删除失败');

	    return redirect()->back();
    }

}
