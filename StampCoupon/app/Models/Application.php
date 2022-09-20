<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $table = 'applications';
    protected $primaryKey = 'id';
    public $timestamps = true;

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
