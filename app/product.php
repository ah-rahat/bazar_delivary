<?php

namespace App;
use App\Review;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'color','price','discount','quantity','status','category_id','sub_category_id','featured_image','gp_image_1',
        'gp_image_2','gp_image_3','gp_image_4','description'
    ];

    public function reviews(){
        return $this->hasMany(Review::class);
    }

}
