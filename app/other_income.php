<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class other_income extends Model
{
    public $timestamps = false;
       protected $fillable = [
       'amount','date','purpose'
    ];
}
