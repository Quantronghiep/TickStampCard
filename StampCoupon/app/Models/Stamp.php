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
        'max_stamp', 'allow_many', 'app_id'
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
        if ($params['allow_many'] == 1) {
            $this->allow_many = 1;
        } else {

            $this->allow_many = 0;
        }

        $this->app_id =  Session::get('app_id');
        $this->save();
    }

    public function updateStamp($params = [], $id)
    {
        //param = request
        $this->max_stamp = $params['max_stamp'];
        // dd($params['allow_many']);
        if ($params['allow_many'] == 1) {
            $this->allow_many = 1;
        } else {

            $this->allow_many = 0;
        }

        $stampFindId = Stamp::find($id);

        $stampFindId->update([
            'max_stamp' => $this->max_stamp,
            'allow_many' => $this->allow_many,
            // 'app_id' =>  $this->app_id,
        ]);
    }


    public function numberMaxStamp()
    {
        // function get number max stamp

        // $max_stamp = DB::table('coupons')
        //     ->join('applications', 'coupons.app_id', '=', 'applications.id')
        //     ->join('stamps', 'applications.id', '=', 'stamps.app_id')
        //     ->where('coupons.app_id', '=',  Session::get('app_id'))
        //     // ->select('stamps.max_stamp')
        //     ->get('stamps.max_stamp');

        $max_stamp = Stamp::with('application')->join('applications', 'stamps.app_id', '=', 'applications.id')
            ->where('stamps.app_id', '=', Session::get('app_id'))->value('max_stamp');
        // dd($max_stamp);
        return $max_stamp; //20
    }


    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
