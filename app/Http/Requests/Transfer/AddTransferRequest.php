<?php

namespace App\Http\Requests\Transfer;

use Illuminate\Foundation\Http\FormRequest;

class AddTransferRequest extends FormRequest
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
            'forward_title' => 'required|string|max:255',
            'deadline_transfert' => 'required|date|date_format:Y-m-d',
            'collaborators' => 'required|array',
            'collaborators.*' => 'required|exists:users,id',
            'description' => 'nullable',
        ];
    }
}
