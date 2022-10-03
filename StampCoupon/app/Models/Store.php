<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $table = 'stores';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name_store', 'address','app_id'
    ];

}
