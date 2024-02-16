<?php

namespace App;
use App\product;
use App\sub_category;
use Illuminate\Database\Eloquent\Model;
use App\child_sub_cats;
class Category extends Model
{
    public function sub_category(){
        return $this->hasMany(sub_category::class);
    }

    public function products(){
        return $this->hasMany(product::class);
    }
    
    
    public $timestamps = false;
}
