<?php

namespace App\Http\Requests\Administrator;

use App\Enums\AdminFunction;
use App\Enums\AdminType;
use App\Enums\Quality;
use App\Rules\Administrator\ArrayElementMatch;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAdministratorRequest extends FormRequest
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
            'name' => 'string|max:255',
            'birthdate' => 'date',
            'birthplace' => 'string|max:255',
            'nationality' => 'string|max:255',
            'address' => 'string|max:255',
            'shares' => 'integer',
            'quality' => [new ArrayElementMatch(Quality::QUALITIES)],
            'function' => [new ArrayElementMatch(AdminFunction::ADMIN_FUNCTIONS)],
            'share_percentage' => 'numeric|between:0,100',
            'type' => ['required', new ArrayElementMatch(AdminType::TYPES)],
            'denomination' => 'required_if:type,corporate',
            'company_head_office' => 'required_if:type,corporate',
            'company_nationality' => 'required_if:type,corporate',

            'appointment_date' => 'date',
            'renewal_date' => 'date',
            'expiry_date' => 'date',
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
