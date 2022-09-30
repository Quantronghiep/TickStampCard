<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateStampRequest;
use App\Models\Stamp;
use Illuminate\Http\Request;

class StampController extends Controller
{

    public function index()
    {
        $stamps = new Stamp();
        $stamps = $stamps->indexStamp();
        return view('admin.stamp.index',[
         'stamps' => $stamps,
     ]);
    }


    public function create()
    {
        return view('admin.stamp.create');
    }


    public function store(CreateStampRequest $request)
    {
        $params = $request->all();
        $params['image_before'] = $request->file('image_before');
        $params['image_after'] = $request->file('image_after');
       
        $stamp = new Stamp();
        $stamp->createStamp($params);
        return redirect('admin/stamp');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $stamp = Stamp::find($id);
        return view('admin.stamp.edit',[
            'stamp' => $stamp
        ]);
    }

    public function update(Request $request, $id)
    {
        // $request->validated();
        $stamp = new Stamp();
        $params = $request->all();
        $params['image_before'] = $request->file('image_before');
        $params['image_after'] = $request->file('image_after');
        $stamp->updateStamp($params,$id);
        return redirect('admin/stamp')->with('success','Update success!');
    }

    public function destroy($id)
    {
        Stamp::find($id)->delete();
        return redirect('admin/stamp')->with('success','Delete success!');
    }
}
