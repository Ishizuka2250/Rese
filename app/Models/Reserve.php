<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'restaurant_id','number', 'reserve_date', 'reserve_time'
    ];
    protected $guarded = array(
        'id'
    );
    public static $rules = array(
        'user_id' => ['required', 'numeric'],
        'restaurant_id' => ['required', 'numeric'],
        'number' => ['required', 'numeric'],
        'reserve_date' => 'required',
        'reserve_time' => 'required'
    );
}
