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
        
    }

    public function registerUser()
    {
        return view('web.register');
    }

    public function checkRegisterUser(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|numeric|digits:10'
        ]);
        $phoneNumberRequest = $request['phone_number'];
        $checkUser = User::where('phone_number', $phoneNumberRequest)->first();
        if (empty($checkUser)) {
            User::create([
                'name' => '',
                'phone_number' => $request['phone_number'],
            ]);
        }
        return $phoneNumberRequest;
    }
}
