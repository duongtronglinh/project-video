<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;

class AdminController extends Controller
{
    public function permission(Request $request)
    {
        foreach ($request->id_user as $value) {
            Permission::create(['user_id' => $value, 'folder_id' => $request->folder_id]);
        }
    }
}
