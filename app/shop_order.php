<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class shop_order extends Model
{
        protected $fillable = [
        'order_total', 'customer_id','delivery_charge','coupon','active_status','delivery_man_id','coupon_discount_amount','approve_status','approve_date'
        ];
 
}
