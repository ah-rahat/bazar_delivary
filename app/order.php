<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
//    protected $fillable = [
//        'order_total', 'customer_id'
//    ];
    public function order_products(){
        return $this->hasMany(product::class);
    }
}
