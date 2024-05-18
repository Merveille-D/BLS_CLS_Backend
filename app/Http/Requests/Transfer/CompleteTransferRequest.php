<?php

namespace App\Http\Requests\Transfer;

use App\Models\Audit\AuditPerformanceIndicator;
use App\Models\Evaluation\Notation;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CompleteTransferRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        $rules = [

            'type' => ['required', Rule::in(['contract', 'audit', 'evaluation'])],

            'model_id' => ['required', 'uuid'],

            // For contract
            // 'date' => ['required_if:type,contract', 'date'],
            'contract_documents' => ['required_if:type,contract', 'array'],
            'contract_documents.*.name' => ['required_if:type,contract', 'string'],
            'contract_documents.*.file' => ['required_if:type,contract', 'file'],

            // For Audit
            'module_id' => ['required_if:type,audit','uuid'],
            'module' => ['required_if:type,audit',Rule::in(AuditPerformanceIndicator::MODULES) ],
            'notes.*.audit_performance_indicator_id' => ['required_if:type,audit','uuid'],

            // For Evaluation or Audit
            'notes' => ['required_if:type,audit,evaluation','array'],
            'notes.*.note' => ['required_if:type,audit,evaluation','numeric'],

            // For Evaluation
            'collaborator_id' => ['required_if:type,evaluation','uuid'],
            'notes.*.performance_indicator_id' => ['required_if:type,evaluation','uuid'],
        ];

        return $rules;
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
