<?php

namespace App\Http\Requests\Recovery;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TransferTaskRequest extends FormRequest
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
            'deadline_transfer' => 'required|date|date_format:Y-m-d',
            'collaborators' => 'required|array',
            'collaborators.*' => 'required|exists:users,id',
            'description' => 'nullable',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(api_error(false, $validator->errors()->first(), $validator->errors()));
    }
}
