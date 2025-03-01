<?php

namespace App\Http\Requests\SessionAdministrator;

use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateAttachementSessionAdministratorRequest extends FormRequest
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
            'session_administrator_id' => ['required', 'uuid'],
            'files' => ['required', 'array'],
            'files.*' => ['required', 'array'],
            'files.*.type' => ['required',  Rule::in(SessionAdministrator::TYPE_FILE_FIELD)],
            'files.*.file' => ['required', 'file'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $validator->errors()->first(),
            'errors' => $validator->errors(),
        ], 422));
    }
}
