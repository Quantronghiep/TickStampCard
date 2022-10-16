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
use Carbon\Carbon;


class TickCardController extends Controller
{
    public function index($app_id, $name_store)
    {
        Session::put('app_id', $app_id);
        Session::put('name_store', $name_store);

        if (Session::get('user_id')) {
            //truong hop sdt ở local storage => user_id có liên kết với app_id
            $checkUserIdByAppIdInTableUsersApps = DB::table('users_apps')->where('user_id', '=', Session::get('user_id'))
                ->where('app_id', '=', Session::get('app_id'))->first();

            if (empty($checkUserIdByAppIdInTableUsersApps)) {
                DB::table('users_apps')->insert([
                    'user_id' => Session::get('user_id'),
                    'app_id' => Session::get('app_id'),
                    'amount' => 0,
                ]);
            }
        }

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

        return view('web.sau_khi_dang_ki', [
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
        $userId = DB::table('users')->where('phone_number', '=',  $request['phone_number'])
            ->value('id');

        Session::put('user_id', $userId);



        // //get amount stamp have
        $amount_stamp = DB::table('users_apps')->where('user_id', '=', $userId)
            ->where('app_id', '=', Session::get('app_id'))
            ->value('amount');

        //reset stamp when tick max stamp
        if ($amount_stamp  == $max_stamp) {
            $amount_stamp = 0;
        }

        //check status tick stamp : 1 or many on day ( 1 yes , 0 no)
        $statusTickStampOnDay = DB::table('stamps')->where('app_id', '=', Session::get('app_id'))->value('allow_many');
        if ($statusTickStampOnDay == 1) {
            $amount_stamp += 1;
            $success = '';
        } else {

            $updated_at = DB::table('users_apps')->where('user_id', '=', $userId)
                ->where('app_id', '=', Session::get('app_id'))
                ->value('updated_at');
            if ((Carbon::now('Asia/Ho_Chi_Minh'))->diffInDays($updated_at) == 0) {
                $success = 'Moi ngay chi duoc tick 1 lan';
            } else {
                $amount_stamp += 1;
                $success = '';
            }
            // $success = (Carbon::now('Asia/Ho_Chi_Minh'))->diffInDays($updated_at);
        }

        //get number coupon cần tích
        $coupon = new Coupon();
        $numberAccumulation = $coupon->numberAccumulationCoupon();

        //get coupon theo app_id
        $couponByAppId = Coupon::with('application')
            ->join('applications', 'coupons.app_id', '=', 'applications.id')
            ->where('coupons.app_id', '=', Session::get('app_id'))
            ->get(['coupons.*'])[0];

        //Save table Users_Coupons when receive coupon
        if ($amount_stamp % $numberAccumulation == 0) {
            $user_coupon_id = DB::table('users_coupons')->insertGetId([
                'user_id' => $userId,
                'coupon_id' => $couponByAppId->id,
                'app_id' =>  Session::get('app_id'),
                'name' => $couponByAppId->name,
                'image' => $couponByAppId->image,
                'description' => $couponByAppId->description,
                'number_accumulation' => $numberAccumulation,
                'note_using' => $couponByAppId->note_using,
                'status' => 0 // chua su dung
            ]);

            //set users_coupons id 
            Session::put('user_coupon_id', $user_coupon_id);
        }


        //update table users_apps amount+1
        $userAppUpdate = DB::table('users_apps')->where('user_id', '=', $userId)
            ->where('app_id', '=', Session::get('app_id'))
            ->update([
                'amount' => $amount_stamp,
                'updated_at' => Carbon::now('Asia/Ho_Chi_Minh')
            ]);

        //get image stamp
        $imageStamp = Image::with('stamp')
            ->join('stamps', 'images_stamp.stamp_id', '=', 'stamps.id')
            ->where([
                ['stamps.app_id', '=', Session::get('app_id')]
            ])
            ->get(['images_stamp.*', 'stamps.id as stamp_id']);

        return response()->json([
            'max_stamp' => $max_stamp,
            'amount_stamp' => $amount_stamp,
            'imageStamp' => $imageStamp,
            'number_accumulation' => $numberAccumulation,
            'couponByAppId' => $couponByAppId,
            'success' => $success
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
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
            ]);
        }

        return $phoneNumberRequest;
    }
}
