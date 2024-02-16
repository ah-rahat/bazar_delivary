<?php

namespace App;
use App\Category;
use Illuminate\Database\Eloquent\Model;
use App\child_sub_cats;
class sub_category extends Model
{
    public function Category(){
        return $this->belongsTo(Category::class);
    }
    public function child_sub_cats(){
        return $this->hasMany(child_sub_cats::class);
    }
     public function products(){
        return $this->hasMany(product::class);
    }
    public $timestamps = false;
}
