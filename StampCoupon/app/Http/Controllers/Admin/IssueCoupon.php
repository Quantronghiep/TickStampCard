<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class IssueCoupon extends Controller
{
    public function couponDetail($id){
        //get coupon theo app_id
        $couponByAppId = Coupon::with('application')
        ->join('applications', 'coupons.app_id', '=', 'applications.id')
        ->where('coupons.app_id', '=', Session::get('app_id'))
        ->where('coupons.id', '=', $id)
        ->first();
         
        return view('web.detail_coupon',[
            'coupon' => $couponByAppId
        ]);
    }

    public function updateStatus(){
        DB::table('users_coupons')->where('user_id', '=', Session::get('user_id'))
        ->where('app_id', '=', Session::get('app_id'))
        ->where('id','=',Session::get('user_coupon_id'))
        ->update(['status' => 1]);
        return "Da su dung thanh cong";
    }

    public function updateStatusUseCoupon(Request $request){
        //save session user_coupon_id when user click use coupon
        Session::put('user_coupon_id', $request->user_coupon_id);
        DB::table('users_coupons')->where('user_id', '=', Session::get('user_id'))
            ->where('app_id', '=', Session::get('app_id'))
            ->where('id','=',Session::get('user_coupon_id'))
            ->update(['status' => 1]);
            return "Da su dung thanh cong";
    }

    public function listCouponReceive(){
        $listCouponReceive =  DB::table('users_coupons')->where('user_id', '=', Session::get('user_id'))
        ->where('app_id', '=', Session::get('app_id'))
       ->get();
        // dd($listCouponReceive);
        return view('web.list_coupon',[
            'listCouponReceive' => $listCouponReceive
        ]);
    }
}
