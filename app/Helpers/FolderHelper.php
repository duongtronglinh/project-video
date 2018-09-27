<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Auth;
 
class FolderHelper
{
    public $ids = [];
    public $string_path;
    public $permission;

    function __construct()
    {
        if (Auth::check()) {
            $this->permission = DB::table('permissions')->where('user_id', Auth::user()->id)->get();
        }
    }
    
    public function getIdParentFolders()
    {
        $ids_parent_folder = [];
        foreach ($this->permission as $pm) {
            $parent_folder = new FolderHelper();
            $parent_folder->getIdParentFolder($pm->folder_id);
            $ids_parent_folder = array_merge($ids_parent_folder, $parent_folder->ids);
        }
        return $ids_parent_folder;
    }

    public function getIdSubfolders()
    {
        $ids_subfolder = [];
        foreach ($this->permission as $pm) {
            $subfolder = new FolderHelper();
            $subfolder->getIdSubfolder($pm->folder_id);
            $ids_subfolder = array_merge($ids_subfolder, $subfolder->ids);
        }
        return $ids_subfolder;
    }

    public function getIdParentFolder($id)
    {
        $fd = DB::table('folders')->where('id', $id)->first();
        if ($fd) {
            $this->ids[] = $fd->id;
            $this->getIdParentFolder($fd->parent_folder_id, $this->ids);
        } else {
            return;
        }
    }

    public function getIdSubfolder($id)
    {
        $this->ids[] = (int)$id;
        $fds = DB::table('folders')->where('parent_folder_id', $id)->get();
        
        if (count($fds)) {
            foreach ($fds as $fd) {
                $this->getIdSubfolder($fd->id);
            }
        } else {
            return;
        }
    }

    public function getPath($id)
    {
        $path = DB::table('folders')->where('id', $id)->first();
        if (!$path) {
            $this->string_path = '<a href="folder">ROOT</a>' . '/' . $this->string_path;
            return;
        } else {
            $this->string_path = '<a href="folder/' . $id . '" >' . $path->name . '</a>/' . $this->string_path;
            $this->getPath($path->parent_folder_id);
        }
    }

    public function countSubfolder($folders, $array = [])
    {
        foreach ($folders as $folder) {
            $array[] = DB::table('folders')->where('parent_folder_id', $folder->id)->count();
        }
        return $array;
    }
}
