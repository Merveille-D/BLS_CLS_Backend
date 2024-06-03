<?php

namespace App\Http\Requests\Guarantee;

use App\Enums\Guarantee\GuaranteeType;
use App\Rules\Administrator\ArrayElementMatch;
use Illuminate\Foundation\Http\FormRequest;

class AddGuaranteeRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        // set security field to property when type is mortgage
        if ($this->type === 'mortgage') {
            $this->merge([
                'security' => 'property',
            ]);
        }
    }

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
            'type' => ['required', new ArrayElementMatch(GuaranteeType::TYPES)],
            'contract_id' => 'required|uuid',
            'security' => 'nullable|string',
            'formalization_type' => 'nullable|string',
        ];
    }
}
