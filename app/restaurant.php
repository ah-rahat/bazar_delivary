<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class restaurant extends Model
{
     protected $fillable = [
        'restaurant_name', 'address','status'
    ];
}
