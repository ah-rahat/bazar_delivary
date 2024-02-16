<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class offer_image extends Model
{
     protected $fillable = [
            'status','color','offer_image','url'
        ];
}
