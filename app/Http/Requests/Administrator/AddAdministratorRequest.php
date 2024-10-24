<?php

namespace App\Http\Requests\Administrator;

use App\Enums\AdminFunction;
use App\Enums\AdminType;
use App\Enums\Quality;
use App\Rules\Administrator\ArrayElementMatch;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddAdministratorRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'birthplace' => 'required|string|max:255',
            'nationality' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'shares' => 'required_if:quality,shareholder|integer',
            'quality' => ['required', new ArrayElementMatch(Quality::QUALITIES)],
            'function' => ['required', new ArrayElementMatch(AdminFunction::ADMIN_FUNCTIONS)],
            'share_percentage' => 'required_if:quality,shareholder|numeric|between:0,100',
            'type' => ['required', new ArrayElementMatch(AdminType::TYPES)],
            'denomination' => 'required_if:type,corporate',
            'company_head_office' => 'required_if:type,corporate',
            'company_nationality' => 'required_if:type,corporate',

            // Mandate
            'appointment_date' => 'required|date',
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
