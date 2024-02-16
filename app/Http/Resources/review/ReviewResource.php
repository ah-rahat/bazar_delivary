<?php

namespace App\Http\Resources\review;

use App\product;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'product_id'=> $this->product_id,
            'product_name'=> $this->product->name,
            'customer_id'=> $this->customer_id,
            'customer_name'=> $this->customer->name,
            'rating'=> $this->rating,
            'review'=> $this->review
        ];
    }
}
