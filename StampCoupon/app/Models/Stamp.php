<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;


class Stamp extends Model
{
    use HasFactory;
    protected $table = 'stamps';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'max_stamp', 'allow_many', 'image_before', 'image_after', 'app_id'
    ];

    public function indexStamp()
    {
        return Stamp::with('application')
            ->join('applications', 'stamps.app_id', '=', 'applications.id')
            ->where('stamps.app_id', '=', Session::get('app_id'))
            ->get(['applications.app_name', 'stamps.*']);
    }

    public function createStamp($params = [])
    {
        $this->max_stamp = $params['max_stamp'];
        // dd($params['allow_many']);
        if($params['allow_many'] == 1){
            $this->allow_many = 1;
        }
        else{

            $this->allow_many = 0;
        }
        
        $this->image_before = $params['image_before'];
        $this->image_after = $params['image_after'];
        if (!empty($this->image_before)) {
            $generatedImage = 'image-stamp-before' . time() . '.' . $this->image_before->extension();
            //move to a folder
            $this->image_before->move(public_path('images'), $generatedImage);
            $this->image_before = $generatedImage;
        }
        if (!empty($this->image_after)) {
            $generatedImage = 'image-stamp-after' . time() . '.' . $this->image_after->extension();
            //move to a folder
            $this->image_after->move(public_path('images'), $generatedImage);
            $this->image_after = $generatedImage;
        }
        $this->app_id =  Session::get('app_id');
        $this->save();
    }

    public function updateStamp($params = [], $id)
    {
        //param = request
        $this->max_stamp = $params['max_stamp'];
        // dd($params['allow_many']);
        if($params['allow_many'] == 1){
            $this->allow_many = 1;
        }
        else{

            $this->allow_many = 0;
        }
        
        // $this->image_before = $params['image_before'];
        // $this->image_after = $params['image_after'];
        // $this->app_id =  Session::get('app_id');
        $stampFindId = Stamp::find($id);

        $stampFindId->update([
            'max_stamp' => $this->max_stamp,
            'allow_many' => $this->allow_many,
            // 'app_id' =>  $this->app_id,
        ]);

        $this->updateImageStamp($params,'image_before',$id);
        $this->updateImageStamp($params,'image_after' ,$id);
    }

    public function updateImageStamp($params = [],$image,$id){
        $stampFindId = Stamp::find($id);
        if (!empty($params[$image])) {
            $destination = 'images/' . $stampFindId[$image];
            if (File::exists($destination)) {
                File::delete($destination);
            };
            $generatedImage = 'image-'.$image.'-' . time() . '.' . $params[$image]->extension();
            //move to a folder
            $params[$image]->move(public_path('images'), $generatedImage);
            $stampFindId->update([
                $image => $generatedImage
            ]);
        } else {
            $stampFindId->update([$image => $stampFindId[$image]]);
        }
    }


    public function numberMaxStamp()
    {
        $max_stamp = DB::table('coupons')
            ->join('applications', 'coupons.app_id', '=', 'applications.id')
            ->join('stamps', 'applications.id', '=', 'stamps.app_id')
            ->where('coupons.app_id', '=',  Session::get('app_id'))
            ->select('stamps.max_stamp')
            ->get();
        // dd($max_stamp[0]->max_stamp);
        return $max_stamp[0]->max_stamp; //20
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
