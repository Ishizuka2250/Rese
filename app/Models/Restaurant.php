<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'detail',
        'image_file_name',
        'area_id',
        'open_time',
        'close_time',
        'max_reserve'
    ];
    protected $guarded = array(
        'id'
    );
    public static $rules = array(
        'name' => 'required',
        'detail' => 'required',
        'image_file_name' => 'required',
        'area_id' => 'required',
        'open_time' => 'required',
        'close_time' => 'required',
        'max_reserve'
    );
}

