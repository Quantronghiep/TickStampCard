<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Application;
use App\Http\Requests\AdminRequest;
use Illuminate\Support\Facades\App;

class AdminController extends Controller
{

    public function index()
    {
        $admins = new Admin();
        $admins = $admins->indexAdmin();
        // dd($admins);
        return view('admin.admin.index',[
            'admins' => $admins,
        ]);
    }


    public function create()
    {
        $apps = Application::all();
        return view('admin.admin.create',[
            'apps' => $apps,
        ]);
    }

    public function store(AdminRequest $request)
    {
        $request->validated();
        $params = $request->all();
       
        $admin = new Admin();
        $admin->createAdmin($params);
        return redirect('admin/admin');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $admin = Admin::find($id);
        $apps = Application::all();
        // $app =  Admin::with('application')
        // ->join('applications', 'admins.app_id', '=', 'applications.id')
        // ->where('admins.app_id','=',$id)
        // ->get();
        // dd($admin);
        return view('admin.admin.edit',[
            'admin' => $admin,
            'apps' => $apps,
        ]);
        
    }


    public function update(AdminRequest $request, $id)
    {
        $request->validated();
        $admin = new Admin();
        $params = $request->all();
        $admin->updateAdmin($params,$id);
        return redirect('admin/admin')->with('success','Update success!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::where('id',$id)->delete();
        return redirect('admin/admin')->with('success','Delete success!');
    }
}
