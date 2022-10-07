<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LocalStorage;
use App\Models\User;

class TickCardController extends Controller
{
    public function index($app_id, $name_store)
    {
        // return  $app_id . 'Name store = ' . $name_store;
        // LocalStorage.setItem('meomeo', 'Tiếng của con mèo');
    }

    public function registerUser()
    {
        return view('web.register');
    }

    public function checkRegisterUser(Request $request)
    {
        $user = User::create([
            'name' => '',
            'phone_number' => $request['phone_number'],
        ]);
        return $user->phone_number;
       
    }
}
