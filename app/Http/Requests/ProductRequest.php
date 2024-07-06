<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'numeric|min:0',
            'stock' => 'integer|min:0'
        ];
        if (request()->isMethod('POST')) {
            $rules = [
                'name' => 'required|string|max:255',
                'description' => 'string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0'
            ];
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Product (name) is required!',
            'price.required' => 'Product (price) is required!',
            'stock.required' => 'Password (stock) is required!',
            'name.*' => 'Invalid Product (name)',
            'price.*' => 'Invalid Product (price)',
            'stock.*' => 'Invalid Product (stock)',
            'description.*' => 'Invalid Product (description)'
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json(['error' => $validator->errors()->first()], 422)
        );
    }
}
