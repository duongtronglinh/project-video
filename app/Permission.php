<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $fillable = ['folder_id', 'user_id'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function folder()
    {
    	return $this->belongsTo('App\Folder');
    }
}
