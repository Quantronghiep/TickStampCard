<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\StoresImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Store;
use Illuminate\Support\Facades\Session;


class StoreController extends Controller
{

    public function index(){
        set_time_limit(0);
        $stores = Store::where('app_id', Session::get('app_id'))->get();
        // dd($stores);
        return view('admin.store.index',[
            'stores' => $stores
        ]);

    }

    public function import() 
    {
        // xoa het store cu
        Store::where('app_id', Session::get('app_id'))->delete();
        Excel::import(new StoresImport, request()->file('file'));
        return redirect()->back()->with('success','Data Imported Successfully');
    }
}
