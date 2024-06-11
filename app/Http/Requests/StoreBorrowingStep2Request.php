<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBorrowingStep2Request extends FormRequest
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
            'assets' => 'required|array|min:1',
            'assets.*.asset_id' => 'required',
            'assets.*.start_date' => 'required|date',
            'assets.*.end_date' => 'required|date|after:assets.*.start_date',
            'assets.*.description' => 'nullable|string',
            'assets.*.num' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'assets.*.asset_id.required' => 'Asset field is required.',
            'assets.*.asset_id.exists' => 'The selected asset is invalid.',
            'assets.*.start_date.required' => 'Start date field is required.',
            'assets.*.start_date.date' => 'Start date must be a valid date.',
            'assets.*.end_date.required' => 'End date field is required.',
            'assets.*.end_date.date' => 'End date must be a valid date.',
            'assets.*.end_date.after' => 'End date must be after start date.',
            'assets.*.description.string' => 'Description must be a string.',
            'assets.*.num.required' => 'Number of assets field is required.',
            'assets.*.num.integer' => 'Number of assets must be an integer.',
            'assets.*.num.min' => 'Number of assets must be at least 1.',
        ];
    }
}
