<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';
    protected $fillable = ['file_name', 'file_path', 'thumbnail', 'folder_id'];

    public function folder()
    {
    	return $this->belongsTo('App\Folder');
    }
}
