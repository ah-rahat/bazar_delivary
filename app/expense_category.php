<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class expense_category extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'type'
    ];

}
