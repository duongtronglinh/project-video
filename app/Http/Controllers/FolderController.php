<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Folder;
use Auth;
use App\Permission;
use App\File;
use App\Helpers\FolderHelper;

class FolderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $folders = Folder::getRootFolder();

        $folder_helper = new FolderHelper();
        $number_subfolders = $folder_helper->countSubfolder($folders);

        if (Auth::check()) {
            $parent_folder = new FolderHelper();
            $ids_parent_folder = $parent_folder->getIdParentFolders();
            return view('page.list_folder', compact('folders', 'number_subfolders', 'ids_parent_folder'));
        }
        return view('page.list_folder', compact('folders', 'number_subfolders'));
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
    public function store(Request $request)
    {
        if (isset($request->parent_folder_id)) {
            $check = Folder::checkNameFolder($request->folder_name, $request->parent_folder_id);
            $check_count_video = File::where('folder_id', $request->parent_folder_id)->count();
            if ($check_count_video > 0) {
                echo json_encode(["flag" => !$check, "error" => $check_count_video]);
            } else {
                if (!$check) {
                    $request->merge([
                        'name' => $request->folder_name,
                        'locked' => 0
                    ]);
                    Folder::create($request->all()); 
                }
                echo json_encode(["flag" => !$check, "error" => $check_count_video]);
            }
        } else {
            $check = Folder::checkNameFolder($request->folder_name, 0);
            if (!$check) {
                $request->merge([
                    'name' => $request->folder_name,
                    'parent_folder_id' => 0,
                    'locked' => 0
                ]);
                $folder = Folder::create($request->all()); 
                echo json_encode(["flag" => !$check, 'folder' => $folder]);
            } else {
                echo json_encode(["flag" => !$check]);
            }
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
        $subfolder = new FolderHelper();
        $ids_subfolder = $subfolder->getIdSubfolders();

        $parent_folder = new FolderHelper();
        $ids_parent_folder = $parent_folder->getIdParentFolders();
                
        if (!(in_array($id, $ids_subfolder) || in_array($id, $ids_parent_folder) || Auth::user()->level == 2)) {
            return redirect('/');
        }
        
        $path_folder = new FolderHelper();
        $path_folder->getPath($id);
        $path = $path_folder->string_path;

        $subfolders = Folder::where('parent_folder_id', $id)->get();
        $folder_helper = new FolderHelper();
        $number_subfolders = $folder_helper->countSubfolder($subfolders);

        if (count($subfolders) > 0) {
            return view('page.list_folder', compact('subfolders', 'path', 'number_subfolders', 
                'ids_parent_folder', 'ids_subfolder'));
        }
        
        $id_folder = $id;
        $files = File::where('folder_id', $id)->paginate(30);
        return view('page.list_video', compact('files', 'path', 'id_folder'));
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
        $subfolder = new FolderHelper();
        $subfolder->getIdSubfolder($id);
        File::whereIn('folder_id', $subfolder->ids)->delete();
        Folder::destroy($subfolder->ids);
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        foreach ($request->id_folder as $value) {
            $subfolder = new FolderHelper();
            $subfolder->getIdSubfolder($value);
            File::whereIn('folder_id', $subfolder->ids)->delete();
            Folder::whereIn('id', $subfolder->ids)->delete();
        }
    }
}
