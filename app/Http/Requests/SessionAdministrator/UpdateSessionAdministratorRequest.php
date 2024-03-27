<?php

namespace App\Http\Requests\SessionAdministrator;

use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateSessionAdministratorRequest extends FormRequest
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
            'session_administrator_id' => ['required', 'numeric'],
            'docs' => ['required', 'array'],
            'docs.files.*' => ['required', 'file'],
            'docs.others_files.*.file' => ['required', 'file'],
            'docs.others_files.*.name' => ['required', 'string'],
            'status' => [Rule::in(SessionAdministrator::SESSION_MEETING_STATUS)],

        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $validator->errors()->first(),
            'errors' => $validator->errors()
        ], 422));
    }
}
