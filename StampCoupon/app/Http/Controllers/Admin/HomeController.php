<?php

namespace App\Http\Controllers\Admin;
use App\Models\Application;

class HomeController
{
    public function index()
    {
        $apps = Application::all();
        return view('admin.layouts.main',[
            'apps' => $apps,
        ]);
    }

}