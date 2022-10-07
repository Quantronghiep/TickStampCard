<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\StampController;
use App\Http\Controllers\Admin\StoreController;

use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\TickCardController;
use App\Http\Controllers\Web\WebController;
use App\Models\Image;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/admin/login',[LoginController::class,'login'])->name('admin.login');
Route::post('/check_login', [LoginController::class, 'checkLogin'])->name('check_login');
Route::get('/logout', [LoginController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('index', [HomeController::class, 'index'])->name('admin.home');
    Route::resource('/admin', AdminController::class);
    Route::resource('/application', ApplicationController::class);
    Route::resource('/coupon', CouponController::class);
    Route::resource('/stamp', StampController::class);
    Route::resource('/image', ImageController::class);
    Route::get('/get-image/{stamp_id}', [ImageController::class, 'getImage']);
    Route::get('/store/index', [StoreController::class, 'index'])->name('store.index');
    Route::post('/store/import', [StoreController::class, 'import'])->name('store.import');

});

Route::prefix('web')->group(function(){
    Route::get('/',[WebController::class,'index'])->name('web');
    Route::get('/detail',[WebController::class,'detail'])->name('web.detail');
    Route::get('/list',[WebController::class,'list'])->name('web.list');
    Route::get('/register_user', [TickCardController::class, 'registerUser'])->name('register_user');
});

Route::get('/tick-card/app_id/{app_id}/name_store/{name_store}',[
   TickCardController::class,
   'index'
]);

Route::post('/check_register_user', [TickCardController::class, 'checkRegisterUser'])->name('check_register_user');
