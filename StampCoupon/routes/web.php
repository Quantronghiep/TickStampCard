<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Web\WebController;
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

Route::prefix('admin')->group(function () {
    Route::get('login',[LoginController::class,'login'])->name('admin.login');
    Route::get('index', [HomeController::class, 'index'])->name('admin.index');
    Route::resource('/admin', AdminController::class);
    Route::resource('/application', ApplicationController::class);
});

Route::prefix('web')->group(function(){
    Route::get('/',[WebController::class,'index']);
});

Route::prefix('web')->group(function(){
    Route::get('/detail',[WebController::class,'detail'])->name('web.detail');
});

Route::prefix('web')->group(function(){
    Route::get('/list',[WebController::class,'list'])->name('web.list');
});
