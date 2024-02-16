<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class delivery_location extends Model
{
        protected $fillable = [
         'location_name', 'location_name_bn', 'charge','min_order_amount'
    ];
       public $timestamps = false;
}
