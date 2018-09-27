<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $table = 'folders';
    protected $fillable = ['name', 'parent_folder_id', 'locked'];

    public function permission()
    {
    	return $this->hasMany('App\Permission');
    }

    public function file()
    {
    	return $this->hasMany('App\File');
    }

    public function scopeCheckNameFolder($query, $name, $parent_id)
    {
        return $query->where([['name', $name], ['parent_folder_id', $parent_id]])->count();
    }

    public function scopeCountSubfolder($query, $id)
    {
        return $query->where('parent_folder_id', $id)->count();
    }

    public function scopeGetRootFolder($query)
    {
        return $query->where('parent_folder_id', 0)->get();
    }
}
