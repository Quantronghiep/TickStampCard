<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Session;


class Admin extends Authenticatable
{
    CONST TYPE_SYSTEM_ADMIN = 1;
    CONST TYPE_APP_ADMIN = 0;

    use HasFactory;
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $guarded = 'admin';
    public $timestamps = true;

    protected $fillable = [
       'email', 'password','type','app_id',
   ];

   public function indexAdmin(){
    // join in eloquent
        return Admin::with('application')
            ->join('applications', 'admins.app_id', '=', 'applications.id')
            ->get(['applications.app_name', 'admins.*']);
        //    dd(DB::table('admins')
        //             ->join('applications','admins.app_id','=','applications.id')
        //             ->select('applications.app_name', 'admins.*')
        //             ->get());
   }

   public function createAdmin($params = []){
        $this->email = $params['email'];
        $this->password = Hash::make($params['password']);
        $this->type = 0;
        $this->app_id = $params['app_id'];
        $this->save();
   }

   public function updateAdmin($params = [] ,$id){
         //param = request
         $this->email = $params['email'];
         $this->password = Hash::make($params['password']);
         $this->app_id = $params['app_id'];
         $adminFindId = Admin::find($id);
        $adminFindId->update([
                 'email' => $this->email,
                 'password' => $this->password,
                 'app_id' => $this->app_id,
             ]);

   }

   public function application(){
    return $this->belongsTo(Application::class);
}
}
