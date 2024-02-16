<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class orderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
//            [
//            'order_id' => 'required',
//            'product_id' => 'required',
//            'quantity' => 'required',
//            'unit_price' => 'required',
//            'total_price' => 'required',
//            'customer_id' => 'required'
//            ]

    }
}
