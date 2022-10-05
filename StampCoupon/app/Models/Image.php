<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;



class Image extends Model
{
    use HasFactory;
    protected $table = 'images_stamp';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'image_before', 'image_after', 'stamp_id'
    ];

    public function indexImage($stamp_id)
    {
        return Image::with('stamp')
            ->join('stamps', 'images_stamp.stamp_id', '=', 'stamps.id')
            ->where([
                ['stamps.app_id', '=', Session::get('app_id')],
                ['images_stamp.stamp_id', '=', $stamp_id]
            ])
            ->get(['images_stamp.*', 'stamps.id as stamp_id']);
    }

    public function createImage($params = [])
    {
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
        $this->stamp_id =  $params['stamp_id'];
        $this->save();
    }

    public function updateImage($params = [], $id)
    {
        $this->updateImageStamp($params, 'image_before', $id);
        $this->updateImageStamp($params, 'image_after', $id);
    }

    public function updateImageStamp($params = [], $image, $id)
    {
        $imageFindId = Image::find($id);
        if (!empty($params[$image])) {
            $destination = 'images/' . $imageFindId[$image];
            if (File::exists($destination)) {
                File::delete($destination);
            };
            $generatedImage = 'image-' . $image . '-' . time() . '.' . $params[$image]->extension();
            //move to a folder
            $params[$image]->move(public_path('images'), $generatedImage);
            $imageFindId->update([
                $image => $generatedImage
            ]);
        } else {
            $imageFindId->update([$image => $imageFindId[$image]]);
        }
    }

    public function compareCountImageLessMaxStamp()
    {
        $stamp = new Stamp();
        $numberMaxStamp =  $stamp->numberMaxStamp();

        $countImage =  Image::with('stamp')
            ->join('stamps', 'images_stamp.stamp_id', '=', 'stamps.id')
            ->where([
                ['stamps.app_id', '=', Session::get('app_id')],
                ['images_stamp.stamp_id', '=', Session::get('stamp_id')]
            ])
            ->count();
        if ($countImage < $numberMaxStamp) {
            return 1;
        }
        return 0;
    }

    public function stamp()
    {
        return $this->belongsTo(Stamp::class);
    }
}
