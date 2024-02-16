<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vendor_request extends Model
{
     protected $fillable = [
        'phone', 'message'
    ];
}
