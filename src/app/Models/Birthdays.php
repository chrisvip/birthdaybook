<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Birthdays extends Model
{
    use HasFactory;
    protected $fillable = array('name', 'birthdate', 'tz');
    protected $guarded = array();
}
