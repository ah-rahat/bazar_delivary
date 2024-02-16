<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class payment extends Model
{
     protected $fillable = [
            'order_id', 'payment_amount','payment_type', 'transaction_number','customer_id'
        ];
}
