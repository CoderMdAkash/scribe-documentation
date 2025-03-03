<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|max:255|unique:categories,name',
            'description' => 'nullable',
        ];

        if ($this->isMethod('patch') || $this->isMethod('put')) {
            $rules['name'] = 'required|max:255|unique:categories,name,' . $this->route('category');
        }

        return $rules;
    }
}
