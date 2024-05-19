<?php

namespace App\Http\Requests\AuditNotation;

use App\Models\Audit\AuditPerformanceIndicator;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreTransferAuditNotationRequest extends FormRequest
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
            'module_id' => ['required','uuid'],
            'module' => ['required',Rule::in(AuditPerformanceIndicator::MODULES) ],

            // For Transfer
            'forward_title' => ['string', 'required_with_all:deadline_transfer,description,collaborators'],
            'deadline_transfer' => ['date', 'required_with_all:forward_title,description,collaborators'],
            'description' => ['string', 'required_with_all:forward_title,deadline_transfer,collaborators'],
            'collaborators' => ['required_with_all:forward_title,deadline_transfer,description','array'],
            'collaborators.*' => ['required_with_all:forward_title,deadline_transfer,description','uuid'],
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
