<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCouponRequest;
use App\Models\Application;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function index()
    {
       $coupons = new Coupon();
       $coupons = $coupons->indexCoupon();
       $apps = Application::all();
       return view('admin.coupon.index',[
        'coupons' => $coupons, 'apps' => $apps,
    ]);
    }

    public function create()
    {
        return view('admin.coupon.create');
    }

    public function store(CreateCouponRequest $request)
    {
        // $params = $request->validated();
        $params = $request->all();
        $params['image'] = $request->file('image');
       
        $coupon = new Coupon();
        $coupon->createCoupon($params);
        return redirect('admin/coupon');

    }

    public function show($id)
    {
        
    }

    public function edit($id)
    {
        $coupon = Coupon::find($id);
       $apps = Application::all();
        return view('admin.coupon.edit',[
            'coupon' => $coupon,
            'apps' => $apps,
        ]);
    }

    public function update(CreateCouponRequest $request, $id)
    {
        $request->validated();
        $coupon = new Coupon();
        $params = $request->all();
        $params['image'] = $request->file('image');
        $coupon->updateCoupon($params,$id);
        return redirect('admin/coupon')->with('success','Update success!');
    }

    public function destroy($id)
    {
        Coupon::find($id)->delete();
        return redirect('admin/coupon')->with('success','Delete success!');
    }
}
