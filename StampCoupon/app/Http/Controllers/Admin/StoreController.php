<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\StoresImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Store;

class StoreController extends Controller
{

    public function index(){
        set_time_limit(0);
        $stores = Store::all();
        return view('admin.store.index',[
            'stores' => $stores
        ]);

    }

    public function import() 
    {
        Store::truncate(); // xoa het store cu
        Excel::import(new StoresImport, request()->file('file'));
        return redirect()->back()->with('success','Data Imported Successfully');
    }
}
