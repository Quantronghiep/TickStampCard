<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Stamp;


class TickCardController extends Controller
{
    public function index($app_id, $name_store)
    {
        // if( Session::get('user_id')){
        //     Session::put('app_id', $app_id);
        //     Session::put('name_store', $name_store);
        //     //get max stamp
        //     $stamp = new Stamp();
        //     $max_stamp = $stamp->numberMaxStamp(); // 10
        //     //get user id theo phonenumber
        //     // dd(Session::get('phone_number'));
        //     $userId = DB::table('users')->where('phone_number', '=',  Session::get('phone_number'))
        //         ->value('id');
        //     // dd($userId);
        //     // //get amount stamp have
        //     $amount_stamp = DB::table('users_apps')->where('user_id', '=', Session::get('user_id'))
        //         ->where('app_id', '=', Session::get('app_id'))
        //         ->value('amount');
        //     //
        //     //get image stamp
        //     $imageStamp = Image::with('stamp')
        //         ->join('stamps', 'images_stamp.stamp_id', '=', 'stamps.id')
        //         ->where([
        //             ['stamps.app_id', '=', $app_id]
        //         ])
        //         ->get(['images_stamp.*', 'stamps.id as stamp_id']);
        //     // dd($imagesStamp);
        //     return view('web.index', [
        //         'max_stamp' => $max_stamp,
        //         'imageStamp' => $imageStamp,
        //         'amount_stamp' => $amount_stamp,
        //     ]);
        // }
        // else{
        //     return redirect()->route('register_user');
        // }
        Session::put('app_id', $app_id);
        Session::put('name_store', $name_store);
        return view('web.index');
    }

    public function dangKyLanDau()
    {
        //get max stamp
        $stamp = new Stamp();
        $max_stamp = $stamp->numberMaxStamp(); // 10

        // //get amount stamp have
        $amount_stamp = DB::table('users_apps')->where('user_id', '=', Session::get('user_id'))
            ->where('app_id', '=', Session::get('app_id'))
            ->value('amount');

        //get image stamp
        $imageStamp = Image::with('stamp')
            ->join('stamps', 'images_stamp.stamp_id', '=', 'stamps.id')
            ->where([
                ['stamps.app_id', '=', Session::get('app_id')]
            ])
            ->get(['images_stamp.*', 'stamps.id as stamp_id']);
        // dd($imagesStamp);

        return view('web.index', [
            'max_stamp' => $max_stamp,
            'amount_stamp' => $amount_stamp,
            'imageStamp' => $imageStamp,
        ]);
    }

    public function tickStampNext(Request $request)
    {
        //get max stamp
        $stamp = new Stamp();
        $max_stamp = $stamp->numberMaxStamp(); // 10

        //get user id theo phonenumber
        // dd(Session::get('phone_number'));
        $userId = DB::table('users')->where('phone_number', '=',  $request['phone_number'])
            ->value('id');
        // dd($userId);       

        // //get amount stamp have
        $amount_stamp = DB::table('users_apps')->where('user_id', '=',$userId)
            ->where('app_id', '=', Session::get('app_id'))
            ->value('amount');

        //update table users_apps amount+1
        $userAppUpdate = DB::table('users_apps')->where('user_id', '=',$userId)
        ->where('app_id', '=', Session::get('app_id'))
        ->update(['amount' => $amount_stamp + 1]);
        // dd($userAppUpdate);

        // return $userAppUpdate;

        //get image stamp
        $imageStamp = Image::with('stamp')
            ->join('stamps', 'images_stamp.stamp_id', '=', 'stamps.id')
            ->where([
                ['stamps.app_id', '=', Session::get('app_id')]
            ])
            ->get(['images_stamp.*', 'stamps.id as stamp_id']);
        // dd($imagesStamp);
        // return view('web.after_tick_stamp', [
        //     'max_stamp' => $max_stamp,
        //     'amount_stamp' => $amount_stamp + 1,
        //     'imageStamp' => $imageStamp,
        // ]);
        return response()->json([
            'max_stamp' => $max_stamp,
            'amount_stamp' => $amount_stamp + 1,
            'imageStamp' => $imageStamp,
        ]);
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
            $user = User::create([
                'name' => '',
                'phone_number' => $phoneNumberRequest,
            ]);

            //set user id create
            Session::put('user_id', $user->id);

            // $user->apps()->attach(Session::get('app_id'), ['amount' =>7]);
            DB::table('users_apps')->insert([
                'user_id' => $user->id,
                'app_id' => Session::get('app_id'),
                'amount' => 1,
            ]);
        }

        return $phoneNumberRequest;
    }
}
