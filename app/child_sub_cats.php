<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\sub_category;
class child_sub_cats extends Model
{
     public function sub_category(){
        return $this->belongsTo(sub_category::class);
    }
     public function products(){
        return $this->hasMany(product::class);
    }
      public function many_sub(){
        return $this->hasMany(sub_category::class);
    }
    public $timestamps = false;
}
