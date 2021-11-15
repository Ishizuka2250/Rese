<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Area;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'area_id'
    ];
    protected $guarded = array(
        'id'
    );
    public static $rules = array(
        'name' => 'required',
        'area_id' => 'required'
    );
}
