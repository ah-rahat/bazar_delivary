<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class prescription extends Model
{
    protected $fillable = [
        'phone', 'file','status','user_id',
    ];
}
