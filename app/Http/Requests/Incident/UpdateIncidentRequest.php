<?php

namespace App\Http\Requests\Incident;

use App\Models\Incident\Incident;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateIncidentRequest extends FormRequest
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
            'title' => ['string'],
            'type' => [Rule::in(Incident::TYPES)],
            'date' => ['date'],
            'author_incident_id' => ['uuid'],
            'user_id' => ['uuid'],
            'client' => ['boolean'],

            'incident_documents' => ['array'],
            'incident_documents.*.name' => ['string'],
            'incident_documents.*.file' => ['file'],

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
