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
            'title' => 'required|string',
            'deadline' => 'required|date',
            'description' => 'nullable|string',
            // 'status' => 'required|string',
            'collaborators' => 'required|required',
            'collaborators.*' => 'required|uuid|exists:users,id',
            // 'completed_user' => 'required|string',
        ];
    }
}
