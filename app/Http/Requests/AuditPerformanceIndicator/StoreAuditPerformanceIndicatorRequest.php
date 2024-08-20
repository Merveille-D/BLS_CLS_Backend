<?php

namespace App\Http\Requests\AuditPerformanceIndicator;

use App\Models\Audit\AuditPerformanceIndicator;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreAuditPerformanceIndicatorRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'module' => ['required',  Rule::in(AuditPerformanceIndicator::MODULES) ],
            'type' => ['required',  Rule::in(AuditPerformanceIndicator::TYPES) ],
            'note' => ['required', 'numeric'],
            'description' => ['required', 'string'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $module_total_note = AuditPerformanceIndicator::where('module', request()->input('module'))->sum('note');

            if($module_total_note >= 100) {
                $validator->errors()->add('actions_number', "Il ne reste plus de points à attribuer pour ce module.");
            }else {
                $note_ask = request()->input('note');
                $note_diff = 100 - $module_total_note;

                if($note_ask > $note_diff) {
                    $validator->errors()->add('actions_number', "Il ne reste que ' . $note_diff .' points à attribuer pour ce module.");
                }
            }
        });
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
