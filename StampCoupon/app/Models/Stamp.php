<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class Stamp extends Model
{
    use HasFactory;

    public function numberMaxStamp(){
        $max_stamp = DB::table('coupons')
        ->join('applications', 'coupons.app_id', '=', 'applications.id')
        ->join('stamps', 'applications.id', '=', 'stamps.app_id')
        ->where('coupons.app_id', '=',  Session::get('app_id'))
        ->select('stamps.max_stamp')
        ->get();
        // dd($max_stamp[0]->max_stamp);
        return $max_stamp[0]->max_stamp; //20
    }
}
