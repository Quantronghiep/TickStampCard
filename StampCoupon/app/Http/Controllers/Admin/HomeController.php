<?php

namespace App\Http\Controllers\Admin;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function index()
    {
        $app_id_system_admin_default = DB::table('applications')->first()->id;
        $idAppActive = empty(Auth::guard('admin')->user()->app_id) ? $app_id_system_admin_default : Auth::guard('admin')->user()->app_id;
        Session::put('app_id', $idAppActive);
        // dd(Session::get('app_id'));
        $apps = Application::all();
        return view('admin.layouts.main',[
            'apps' => $apps,
        ]);
    }

}