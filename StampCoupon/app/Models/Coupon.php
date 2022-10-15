<?php

namespace App\Models;

use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;



class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name', 'image', 'description', 'number_accumulation', 'note_using', 'app_id'
    ];

    public function indexCoupon()
    {
        return Coupon::with('application')
            ->join('applications', 'coupons.app_id', '=', 'applications.id')
            ->where('coupons.app_id', '=', Session::get('app_id'))
            ->get(['applications.app_name', 'coupons.*']);
    }

    public function createCoupon($params = [])
    {
        $this->name = $params['name'];
        $this->image = $params['image'];
        if (!empty($this->image)) {
            $generatedImage = 'image-coupon' . time() . '-' . $this->name . '.' . $this->image->extension();
            //move to a folder
            $this->image->move(public_path('images'), $generatedImage);
            $this->image = $generatedImage;
        }
        $this->description = $params['description'];
        $this->number_accumulation = $params['number_accumulation'];
        // dd( $this->number_accumulation );

        $this->note_using = $params['note_using'];
        $this->app_id =  Session::get('app_id');
        $this->save();
    }

    public function updateCoupon($params = [], $id)
    {
        //param = request
        $this->name = $params['name'];
        $this->image = $params['image'];
        $this->description = $params['description'];
        $this->number_accumulation = $params['number_accumulation'];
        $this->note_using = $params['note_using'];
        $this->app_id = Session::get('app_id');
        $couponFindId = Coupon::find($id);

        $couponFindId->update([
            'name' => $this->name,
            'description' => $this->description,
            'number_accumulation' => $this->number_accumulation,
            'note_using' => $this->note_using,
            'app_id' => Session::get('app_id'),
        ]);

        if (!empty($params['image'])) {
            $destination = 'images/' . $couponFindId['image'];
            if (File::exists($destination)) {
                File::delete($destination);
            };
            $generatedImage = 'image-coupon' . time() . '-' . $this->name . '.' . $this->image->extension();
            //move to a folder
            $params['image']->move(public_path('images'), $generatedImage);
            $couponFindId->update([
                'image' => $generatedImage
            ]);
        } else {
            $couponFindId->update(['image' => $couponFindId['image']]);
        }
    }

    public function numberAccumulationCoupon()
    {
        // function get number_accumulation_coupon

        $number_accumulation = Coupon::with('application') ->join('applications', 'coupons.app_id', '=', 'applications.id')
        ->where('coupons.app_id', '=', Session::get('app_id'))->value('number_accumulation');
           
        return $number_accumulation; //5
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
