<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddVideoRequest;
use App\Folder;
use App\File;
use App\Permission;
use Auth;
use App\Helpers\FolderHelper;

class VideoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $folder = Folder::findOrFail($request->id);
        $path_folder = new FolderHelper();
        $path_folder->getPath($request->id);
        $path = strip_tags($path_folder->string_path);

        return view('page.add_video', compact('folder', 'path'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddVideoRequest $request)
    {
        $has_subfolder =  Folder::where('parent_folder_id', $request->parent_folder_id)->count();
        if ($has_subfolder) {
            return redirect()->back()->with('error_add_video', trans('multi_language.session.error_add_video'));
        }

        $parent_folder = new FolderHelper();
        $parent_folder->getIdParentFolder($request->parent_folder_id);
        $check_permission = Permission::where('user_id', Auth::check())
            ->whereIn('folder_id', $parent_folder->ids)->count();
            
        if (!($check_permission || Auth::user()->level == 2)) {
            return redirect()->back()->with('error_add_video', trans('multi_language.session.error_add_video'));
        }

        $file_video = $request->file('video_file');
        $video_file_name = uniqid() . $file_video->getClientOriginalName();
        $file_video->move(config('app.upload_file'), $video_file_name);

        $file_thumbnail = $request->file('thumbnail_picture');
        $thumbnail_file_name = uniqid() . $file_thumbnail->getClientOriginalName();
        $file_thumbnail->move(config('app.upload_file'), $thumbnail_file_name);

        $request->merge([
            'file_path' => $video_file_name,
            'thumbnail' => $thumbnail_file_name,
            'folder_id' => $request->parent_folder_id,
            'file_name' => $request->video_name
        ]);
        File::create($request->all());
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video_delete = File::findOrFail($id);
        if (file_exists(config('app.upload_file') . '/' . $video_delete->thumbnail)) {
            unlink(config('app.upload_file') . '/' . $video_delete->thumbnail);
        }
        if (file_exists(config('app.upload_file') . '/' . $video_delete->file_path)) {
            unlink(config('app.upload_file') . '/' . $video_delete->file_path);
        }
        $video_delete->delete();
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $videos_delete = File::whereIn('id', $request->id_video)->get();
        foreach ($videos_delete as $video_delete) {
            if (file_exists(config('app.upload_file') . '/' . $video_delete->thumbnail)) {
                unlink(config('app.upload_file') . '/' . $video_delete->thumbnail);
            }
            if (file_exists(config('app.upload_file') . '/' . $video_delete->file_path)) {
                unlink(config('app.upload_file') . '/' . $video_delete->file_path);
            }
            $video_delete->delete();
        }
    }
}
