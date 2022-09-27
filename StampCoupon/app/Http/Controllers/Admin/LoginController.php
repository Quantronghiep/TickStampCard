<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function checkLogin(Request $request)
    {
        if (Auth::guard('admin')->attempt(['email' => $request->email,
        'password' => $request->password,
        ])) {
            return redirect()->route('admin.home');
        }

        return redirect()->route('admin.login')->with('error', 'FAILED LOGIN');
    }

    public function login(){
        return view('admin.login.login');
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->route('admin.login');
    }


}
