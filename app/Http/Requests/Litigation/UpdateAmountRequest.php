<?php

namespace App\Http\Requests\Litigation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAmountRequest extends FormRequest
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
            'estimated_amount' => 'numeric|required|min:0',
            'added_amount' => 'numeric|nullable|min:0',
            'remaining_amount' => 'numeric|nullable|min:0',
        ];
    }
}
