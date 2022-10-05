<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Stamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ImageController extends Controller
{

    public function index()
    {
        $stamps = new Stamp();
        Session::put('stamp_id',  $stamps->first()->id);
        $stamps = $stamps->indexStamp();
        // dd($stamp_id);
        $images = new Image();
        $images = $images->indexImage(Session::get('stamp_id'));
        // dd($images);
        return view('admin.image.index', [
            'images' => $images,
            'stamps' => $stamps
        ]);
    }

    public function getImage($stamp_id)
    {
        $images = new Image();
        $images = $images->indexImage($stamp_id);
        return $images;
    }

    public function create()
    {
        $image = new Image();
        $check = $image->compareCountImageLessMaxStamp();
        if ($check == 1) {
            $stamps = new Stamp();
            $stamps = $stamps->indexStamp();
            return view('admin.image.create', [
                'stamps' => $stamps

            ]);
        }
        else {
            $error = 'So luong anh da qua gioi han';
            return back()->with('error',$error);
        }
    }


    public function store(Request $request)
    {
        $params = $request->all();
        $params['image_before'] = $request->file('image_before');
        $params['image_after'] = $request->file('image_after');

        $stamp = new Image();
        $stamp->createImage($params);
        return redirect('admin/image');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $image = Image::find($id);
        return view('admin.image.edit', [
            'image' => $image
        ]);
    }

    public function update(Request $request, $id)
    {
        $image = new Image();
        $params['image_before'] = $request->file('image_before');
        $params['image_after'] = $request->file('image_after');
        $image->updateImage($params, $id);
        return redirect('admin/image')->with('success', 'Update success!');
    }


    public function destroy($id)
    {
        Image::find($id)->delete();
        return redirect('admin/image')->with('success', 'Delete success!');
    }
}
