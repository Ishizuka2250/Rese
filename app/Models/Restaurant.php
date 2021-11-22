<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'area_id', 'detail', 'image_file_name'
    ];
    protected $guarded = array(
        'id'
    );
    public static $rules = array(
        'name' => 'required',
        'area_id' => 'required',
        'detail' => 'required',
        'image_file_name' => 'required'
    );
}

