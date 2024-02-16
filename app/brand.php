<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class brand extends Model
{

    protected $fillable = [
        'brand_name','brand_img'
    ];

    public function brand_products(){
        return $this->hasMany(product::class);
    }
    public $timestamps = false;
}
