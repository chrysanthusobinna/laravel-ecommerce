<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ];

        if ($this->isMethod('post')) {
            $rules['images'] = 'required|array|min:1';
            $rules['images.*'] = 'required|image|max:2048';
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['images'] = 'nullable|array';
            $rules['images.*'] = 'nullable|image|max:2048';
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'name' => ucwords($this->name),
        ]);
    }
}
