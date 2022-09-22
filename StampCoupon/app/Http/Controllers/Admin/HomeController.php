<?php

namespace App\Http\Controllers\Admin;

class HomeController
{
    public function index()
    {
        return view('admin.layouts.main');
    }

    public function detail()
    {
        return view('user.detail');
    }

    public function list()
    {
        return view('user.list');
    }
}