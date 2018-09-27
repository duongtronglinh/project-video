<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\User;
use Auth;
use App\File;

class PageController extends Controller
{
    public function home()
    {
        return view('page.home');
    }

    public function login(LoginRequest $request)
    {
        $check_login = ['email' => $request->email, 'password' => $request->password];
        if (Auth::attempt($check_login, $request->remember_me)) {
            return redirect()->back();
        } else {
            return redirect()->back()->with('error_login', trans('multi_language.session.error_login'));
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->back();
    }

    public function changeLanguage($language, Request $request)
    {
        $request->session()->put('locale', $language);
        return redirect()->back();
    }

    public function download($id)
    {
        $file = File::findOrFail($id);
        $file_download = config('app.upload_file') . '/' . $file->file_path;

        if (file_exists($file_download)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $file->file_path);
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_download));
            ob_clean();
            flush();
            readfile($file_download);
            exit;
        }
    }

    // public function downloadAll(Request $request)
    // {
    //     $files = File::whereIn('id', $request->id_video)->get();
    //     foreach ($files as $file) {
    //         $file_download = config('app.upload_file') . '/' . $file->file_path;
    //         if (file_exists($file_download)) {
    //             header('Content-Description: File Transfer');
    //             header('Content-Type: application/octet-stream');
    //             header('Content-Disposition: attachment; filename=' . $file->file_path);
    //             header('Expires: 0');
    //             header('Cache-Control: must-revalidate');
    //             header('Pragma: public');
    //             header('Content-Length: ' . filesize($file_download));
    //             // ob_clean();
    //             // flush();
    //             // readfile($file_download);
    //             // exit;
    //         }
    //     }
    // }
}
