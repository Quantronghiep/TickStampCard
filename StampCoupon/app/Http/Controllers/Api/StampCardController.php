<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\StampCard as StampCardResource;
use App\Models\Application;
use App\Models\Stamp;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Image;
use App\Models\StampCard;

class StampCardController extends Controller
{
    public function getStampCard($app_id, $phone)
    {
        //get app_name by app_id
        $app_name = Application::where('id', $app_id)->value('app_name'); //lotte

        Session::put('app_id', $app_id);
        Session::put('phone', $phone);

        $stampCard = new StampCard();
        //get max stamp by app_id
        $max_stamp = $stampCard->getNumberMaxStamp();

        $arrImageTicked = $stampCard->getArrayImage();

        return response()->json([
            'app_name' => $app_name,
            'max_stamp' => $max_stamp,
            // 'status' => 'success',
            'stamp_images' => $arrImageTicked,
        ], Response::HTTP_OK);
    }

    public function addStampCard($app_id, $phone){
        Session::put('app_id', $app_id);
        Session::put('phone', $phone);
        $stampCard = new StampCard();

        $checkAddStampCard = $stampCard->addStamp();
        if($checkAddStampCard == 0){
            return response()->json([
                'status' => 'false',
            ]);
        }
        else {
            return response()->json([
                'status' => 'true',
            ]);
        }
    }
}
