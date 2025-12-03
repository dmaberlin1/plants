<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:0'],
            'type_id' => ['required', 'integer', 'exists:plant_types,id'],
            'protection_products' => ['nullable', 'array'],
            'protection_products.*.id' => ['required', 'integer', 'exists:plant_protection_products,id'],
            'protection_products.*.dose' => ['required', 'numeric', 'min:0'],
        ];
    }
}
