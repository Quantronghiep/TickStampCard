<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index(){
        // return view('web.index');
        phpinfo();
    }

    public function detail(){
        return view('web.detail_coupon');
    }

    public function list(){
        return view('web.list_coupon');
    }
}
