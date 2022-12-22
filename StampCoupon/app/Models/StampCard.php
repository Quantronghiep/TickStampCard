<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StampCard extends Model
{
    use HasFactory;

    public function getNumberMaxStamp(){
         //get max stamp by app_id
         $stamp = new Stamp();
         return $stamp->numberMaxStamp(); //12
    }

    public function getUserIdByPhone(){
         //get id user by phone
         return DB::table('users')->where('phone_number', '=',  Session::get('phone'))
         ->value('id');
    }

    public function getAmountStampHave(){
        //get amount stamp have
        return DB::table('users_apps')->where('user_id', '=', $this->getUserIdByPhone())
            ->where('app_id', '=', Session::get('app_id'))
            ->value('amount');
    }

    public function getImageStampTicked(){
        $amount_stamp = $this->getAmountStampHave();
         //get image stamp ticked
         return Image::with('stamp')
         ->join('stamps', 'images_stamp.stamp_id', '=', 'stamps.id')
         ->where([
             ['stamps.app_id', '=', Session::get('app_id')]
         ])
         ->skip(0)->take($amount_stamp)
         ->get(['images_stamp.image_before', 'images_stamp.image_after']);
    }

    public function getImageStampNoTick(){
        $amount_stamp = $this->getAmountStampHave();
       $max_stamp = $this->getNumberMaxStamp();
        return Image::with('stamp')
        ->join('stamps', 'images_stamp.stamp_id', '=', 'stamps.id')
        ->where([
            ['stamps.app_id', '=', Session::get('app_id')]
        ])
        ->skip($amount_stamp)->take($max_stamp-$amount_stamp)
        ->get(['images_stamp.image_before', 'images_stamp.image_after']);
    }
    
    public function getArrayImage(){
        $imageStampTicked = $this->getImageStampTicked();
        $imageStampNoTick = $this->getImageStampNoTick();
        $numberCountStampTicked = count($imageStampTicked);
        $numberCountStampNoTick = count($imageStampNoTick);

        $arrImageTicked = [];
        for ($i = 0; $i < $numberCountStampTicked; $i++) {
            $arrImageTicked[$i + 1] = $imageStampTicked[$i]->image_after;
        }
        for ($i = 0; $i < $numberCountStampNoTick; $i++) {
            $arrImageTicked[$numberCountStampTicked + 1] = $imageStampNoTick[$i]->image_before;
            $numberCountStampTicked += 1;
        }
        return $arrImageTicked;
    }

    public function addStamp(){
        $user_id = $this->getUserIdByPhone();
        $amount_stamp = $this->getAmountStampHave();
        $checkUserApp = DB::table('users_apps')->where('user_id', '=', $user_id)
        ->where('app_id', '=', Session::get('app_id'))->get();

        if(count($checkUserApp) == 0){
            return 0 ;
        }
        else{
             DB::table('users_apps')->where('user_id', '=', $user_id)
            ->where('app_id', '=', Session::get('app_id'))
            ->update(['amount' => $amount_stamp + 1]);
            return 1;
        }
    }
}
