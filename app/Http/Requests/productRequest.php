<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productRequest extends FormRequest
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
        return [
           'name' => 'required',
           'slug' => 'required',
           'category_id' => 'required',
           'sub_category_id' => 'required',
           'color' => 'required',
           'price' => 'required',
           'discount' => 'required',
           'quantity' => 'required',
           'status' => 'required',
           'user_id' => 'required'
        ];
    }
}
