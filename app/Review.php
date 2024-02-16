<?php

namespace App;
use App\product;
use App\Customer;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public function product(){
        return $this->belongsTo(product::class);
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
//    public function customers(){
//        return $this->hasMany(Customer::class);
//    }
}
