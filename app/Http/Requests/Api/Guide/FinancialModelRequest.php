<?php

namespace App\Http\Requests\Api\Guide;

use Illuminate\Foundation\Http\FormRequest;

class FinancialModelRequest extends FormRequest
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
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'string', 'min:2'],
            'file' => ['required', 'file', ],
            'image' => ['required', 'image', 'mimes:jpg,png,jpeg,gif'],
        ];
    }
}
