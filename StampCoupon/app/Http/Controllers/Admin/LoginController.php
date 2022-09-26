<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function check_login(Request $request)
    {
        $remember = (bool)$request->remember;
        if (Auth::guard('admin')->attempt(['email' => $request->email,
            'password' => $request->password,
            'type' => 1,
//            $remember,
        ], $remember)) {
            return redirect()->route('admin.home');
        }
        if (Auth::guard('admin')->attempt(['email' => $request->email,
            'password' => $request->password,
            'type' => 0,
        ], $remember)) {
            return redirect()->route('admin.home');
        }

        return redirect()->route('admin.login')->with('error', 'FAILED LOGIN');
    }

    public function login(){
        // if (auth()->check()) {
        //     return redirect('/');
        // }
        return view('admin.login.login');
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->route('admin.login');
    }


}
