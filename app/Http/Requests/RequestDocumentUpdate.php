<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestDocumentUpdate extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => [
                'required',
                Rule::exists('documents', 'id'),
            ],
            'name' => 'required',
            'values' => 'required|array|min:1',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'The id field is required.',
            'id.exists' => 'The selected id is invalid.',
            'name.required' => 'The name field is required.',
            'values.required' => 'The values field is required.',
            'values.array' => 'The values must be an array.',
            'values.min' => 'The values array must have at least one entry.',
        ];
    }
}
