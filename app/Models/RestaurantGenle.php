<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantGenle extends Model
{
    use HasFactory;
    protected $fillable = [
        'restaurant_id', 'genle_id'
    ];
    protected $guarded = Array(
        'id'
    );
    public static $rules = Array(
        'restaurant_id' => 'required',
        'genle_id' => 'required'
    );
}
