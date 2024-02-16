<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product_request extends Model
{
     protected $fillable = [
        'phone', 'name'
    ];
}
