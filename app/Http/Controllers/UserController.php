<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\EditUserRequest;
use App\User;
use App\Folder;
use App\Permission;
use App\Helpers\FolderHelper;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (isset($request->folder_id)) {
            $folder_id = $request->folder_id;
            
            $user_permission = User::whereNotIn('id', Permission::select('user_id')->where('folder_id', $folder_id))
                ->where('level', 1)->get();
            
            $path_folder = new FolderHelper();
            $path_folder->getPath($folder_id);
            $path = $path_folder->string_path;

            if (isset($request->permit)) {
                $list_user_permission = Permission::where('folder_id', $folder_id)->get();
                return view('page.list_user', compact('list_user_permission', 'path'));
            }
            return view('page.list_user', compact('user_permission', 'path', 'folder_id'));
        }
        $users = User::all();
        return view('page.list_user', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddUserRequest $request)
    {
        $request->merge(['password' => bcrypt($request->password)]);
        User::create($request->all());
        return redirect()->back()->with('success_add', trans('multi_language.session.success_add'));
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
        $user = User::findOrFail($id);
        return view('page.update_user', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, $id)
    {
        User::findOrFail($id)->update(['password' => bcrypt($request->password)]);
        return redirect()->back()->with('success_edit', trans('multi_language.session.success_edit'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back();
    }
}
