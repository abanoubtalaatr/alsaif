<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i'],
            'name' => ['required', 'string'],
            'company_name' => ['nullable', 'string'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string'],
            'labor_sector' => ['nullable', 'string'],
            'first_time_i_heard_about_us' => ['nullable', 'string'],
        ];
    }
}
