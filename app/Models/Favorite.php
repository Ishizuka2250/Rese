<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'restaurant_id'
    ];
    protected $guarded = Array(
        'id'
    );
    public static $rules = Array(
        'user_id' => 'required',
        'restaurant_id' => 'required'
    );
}
