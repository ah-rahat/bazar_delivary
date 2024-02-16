<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order_item extends Model
{
    protected $fillable = [
        'order_id', 'product_id','quantity', 'unit_price','total_price', 'customer_id'
    ];
}
