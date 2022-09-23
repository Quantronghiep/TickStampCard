<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Application extends Model
{
    use HasFactory;
    protected $table = 'applications';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
       'app_name', 'logo'
   ];

    public function createApp($params = []){
        $this->app_name = $params['app_name'];
        $this->logo = $params['logo'];
        if(!empty($this->logo)){
            $generatedImage = 'image'.time().'-'. $this->app_name .'.'.$this->logo->extension();
            //move to a folder
            $this->logo->move(public_path('images') , $generatedImage);
            $this->logo = $generatedImage;
        }
        $this->save();
    }

    public function updateApp($params = [] ,$id){
        //param = request
        $this->app_name = $params['app_name'];
        $this->logo = $params['logo'];
        $appFindId = Application::find($id);

        if(!empty($params['logo'])){
            $destination = 'images/'.$appFindId['logo'];
            // dd($destination);
            if(File::exists($destination)){
                File::delete($destination);
            };
            $generatedImage = 'image'.time().'-'. $this->app_name .'.'.$this->logo->extension();
            //move to a folder
            $params['logo']->move(public_path('images'),$generatedImage);
            $appFindId->update([
                'app_name' => $this->app_name,
                'logo' => $generatedImage
            ]);
        }
        else{
            $this->update(['app_name' => $this->name ]);
        }
    }

    //one app has many admins
    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

     public function stores()
     {
         return $this->hasMany(Store::class);
     }


    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

     public function users_coupons()
     {
         return $this->hasMany(User_Coupon::class);
     }

    public function users_apps()
    {
        return $this->hasMany(User_App::class);
    }
}
