<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            "product_name" => ['bail','required', Rule::unique('products','product_name')->ignore($this->id, 'id')->whereNull('deleted_at')],
            "product_unit" => ['bail','required'],
            "product_unit_value" => ['bail','required','numeric'],
        ];
        if (!empty($this->attribute) && $this->attribute == 'size'){
            $rules['attribute_size'] = ['bail','required'];
        }
        if (!empty($this->attribute) && $this->attribute == 'color'){
            $rules['attribute_color'] = ['bail','required'];
        }
        $rules['selling_price'] = ['bail','required','regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'];
        $rules['purchase_price'] = ['bail','required','regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'];
        $rules['discount'] = ['nullable','regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'];
        $rules['tax'] = ['nullable','regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'];
        $rules['product_image'] = ['nullable','mimes:jpg,jpeg,png,bmp,gif,svg,webp|max:1024'];

        return $rules;
    }
}
