<?php

namespace App\Http\Resources\product;

use Illuminate\Http\Resources\Json\JsonResource;

class productResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return
            [
                'id' => $this->id,
                'name' => $this->name,
                'name_bn' => $this->name_bn,
                'slug' => $this->slug,
                'price' => $this->price,
                'discount' => $this->discount,
                'featured_image' => $this->featured_image,
//                'total_price' => round((1 - ($this->discount / 100)) * $this->price,  0),
//                'quantity' => $this->quantity == 0 ? "Out of Stock" : $this->quantity,
                'stock_quantity' => $this->stock_quantity,
                'unit' => $this->unit,
                'unit_quantity' => $this->unit_quantity,
                'status' => $this->status,
                'category_id' => $this->category_id,
                'sub_category_id' => $this->sub_category_id,
                'child_sub_category_id' => $this->child_sub_cats_id,
                'description' => $this->description,
                'gp_image_1' => $this->gp_image_1,
                'gp_image_2' => $this->gp_image_2,
                'gp_image_3' => $this->gp_image_3,
                'gp_image_4' => $this->gp_image_4,
                'tags' => $this->tags,
            ];
    }
}
