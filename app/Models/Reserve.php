<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'restaulant_id', 'reserve_date'
    ];
    protected $guarded = array(
        'id'
    );
    public static $rules = array(
        'user_id' => 'required',
        'restaulant_id' => 'required',
        'reserve_date' => 'required'
    );
}
