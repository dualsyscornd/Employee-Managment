<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Session;

class AuthController extends Controller
{
    // Login View Functions --------------------------------

    public function Login()
    {
        return view('Admin.Auth.Login');
    }

    // Admin Login  Functions --------------------------------
    public function AdminLogin(Request $req)
    {
        $data = DB::table('admin')
            ->where('admin_email', $req->input('admin_email'))
            ->where('admin_password', $req->input('admin_password'))
            ->get();

        if (count($data) > 0) {
            $data = $data[0];
            Session::put('admin_id', $data->admin_id);
            Session::put('admin_name', $data->admin_name);
            Session::put('admin_email', $data->admin_email);
            Session::put('admin_password', $data->admin_password);
            Session::save();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    // Admin Logout  Functions --------------------------------
    public function Logout(Request $req)
    {
        $req->session()->flush();
        $req->session()->regenerate();
        return redirect('/');
    }

}
