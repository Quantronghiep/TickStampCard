<?php

namespace App\Http\Controllers\Admin;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController
{
    public function index()
    {
        $app_id_system_admin_default = DB::table('applications')->first()->id;
        $idAppActive = empty(Auth::guard('admin')->user()->app_id) ? $app_id_system_admin_default : Auth::guard('admin')->user()->app_id;
        Session::put('app_id', $idAppActive);
        // dd(Session::get('app_id'));
        $apps = Application::all();
        // return response()->json(['apps' => $apps]);
        // dd($apps);
        return view('admin.layouts.main',[
            'apps' => $apps,
        ]);
        // return view('admin.layouts.main');
    }
    public function getApp()
    {
        
        $apps = Application::all();
        return response()->json(['apps' => $apps]);
        
    }

    public function setAppId(Request $request){
        Session::put('app_id', $request['app_id']);
    }

}