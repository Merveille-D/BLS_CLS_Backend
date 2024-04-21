<?php

namespace App\Http\Requests\Recovery;

use App\Rules\Administrator\ArrayElementMatch;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class InitRecoveryRequest extends FormRequest
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
            'name' => 'required|string',
            'type' => ['required', new ArrayElementMatch(['friendly', 'forced'])],
            // 'has_guarantee' => 'nullable|boolean',
            'has_guarantee' => 'required_if:type,forced|boolean',
        ];
    }


    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['success' => false, 'message' => 'Une erreur s\'est produite', 'errors' => $validator->errors()], 422));
    }
}
