<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class coupon extends Model
{
    protected $fillable = [
        'coupon_code', 'coupon_discount', 'accepted_orders_amount', 'active_from', 'active_until','coupon_used','status','created_by'
     ];
}
