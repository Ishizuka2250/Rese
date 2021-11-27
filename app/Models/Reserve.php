<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Restaurant;

class Reserve extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'restaurant_id', 'reserve_date', 'reserve_time'
    ];
    protected $guarded = array(
        'id'
    );
    public static $rules = array(
        'user_id' => 'required',
        'restaurant_id' => 'required',
        'number' => 'required',
        'reserve_date' => 'required',
        'reserve_time' => 'required'
    );
}
