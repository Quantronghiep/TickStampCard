<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

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


    public function store(Request $request)
    {
        $app = new Application();
        $app->app_name = $request->input('app_name');
        if(!empty($request->logo)){
            $generatedImage = 'image'.time().'-'. $request->app_name .'.'.$request->logo->extension();
            //move to a folder
            $request->logo->move(public_path('images'),$generatedImage);
            $app->logo = $generatedImage;
        }
        $app->save();
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

    public function update(Request $request, $id)
    {
        $app = Application::find($id);
        if(!empty($request->logo)){
            $destination = 'images/'.$app->logo;
            // dd($destination);
            if(File::exists($destination)){
                File::delete($destination);
            };
            $generatedImage = 'image'.time().'-'. $request->app_name .'.'.$request->logo->extension();
            //move to a folder
            $request->logo->move(public_path('images'),$generatedImage);
            $app->update([
                'app_name' => $request->input('app_name'),
                'logo' => $generatedImage
            ]);
        }
        else{
            $app->update(['app_name' => $request->input('app_name') ]);
        }
        return redirect('admin/application')->with('success','Update success!');
    }

    public function destroy($id)
    {
        Application::where('id',$id)->delete();
        return redirect('admin/application')->with('success','Delete success!');
    }
}
