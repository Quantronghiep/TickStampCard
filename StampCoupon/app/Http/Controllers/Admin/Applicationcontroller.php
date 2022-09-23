<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ApplicationRequest;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apps = Application::all();
        return view('admin.application.index',[
            'apps' => $apps,
        ]);
    }

    public function create()
    {
        return view('admin.application.create');
    }


    public function store(ApplicationRequest $request)
    {
        $request->validated();
        $params = $request->all();

        $app = new Application();
        $app->create($params);
        return redirect('admin/application');
;    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $app = Application::find($id);
        return view('admin.application.edit')->with('app',$app);
    }

    public function update(ApplicationRequest $request, $id)
    {
        $request->validated();
        $app = new Application();
        $params = $request->all();
        $app->updateApp($params,$id);
        return redirect('admin/application')->with('success','Update success!');
        
        // if(!empty($request->logo)){
        //     $destination = 'images/'.$app->logo;
        //     // dd($destination);
        //     if(File::exists($destination)){
        //         File::delete($destination);
        //     };
        //     $generatedImage = 'image'.time().'-'. $request->app_name .'.'.$request->logo->extension();
        //     //move to a folder
        //     $request->logo->move(public_path('images'),$generatedImage);
        //     $app->update([
        //         'app_name' => $request->input('app_name'),
        //         'logo' => $generatedImage
        //     ]);
        // }
        // else{
        //     $app->update(['app_name' => $request->input('app_name') ]);
        // }
        // return redirect('admin/application')->with('success','Update success!');
    }

    public function destroy($id)
    {
        Application::where('id',$id)->delete();
        return redirect('admin/application')->with('success','Delete success!');
    }
}
