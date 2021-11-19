<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genle extends Model
{
    use HasFactory;
    protected $fillable = [
        'genle'
    ];
    protected $guarded = Array(
        'id'
    );
    public static $rules = Array(
        'genle' => 'required'
    );
}
