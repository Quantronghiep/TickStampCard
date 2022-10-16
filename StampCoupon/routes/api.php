<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StampCardController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function(){ 
    Route::get('/stamp_card/app_id/{app_id}/phone/{phone}',[ StampCardController::class ,'getStampCard'])->name('getStampCard');
    Route::post('/stamp_card/add_stamp/app_id/{app_id}/phone/{phone}',[ StampCardController::class ,'addStampCard'])->name('addStampCard');
});
