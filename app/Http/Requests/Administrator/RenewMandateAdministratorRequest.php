<?php

namespace App\Http\Requests\Administrator;

use App\Models\Gourvernance\BoardDirectors\Administrators\CaAdministrator;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RenewMandateAdministratorRequest extends FormRequest
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
            'administrator_id' => [
                'uuid',
                function ($attribute, $value, $fail) {

                    $last_mandate = CaAdministrator::find(request()->input('administrator_id'))->lastMandate();

                    if ($last_mandate->expiry_date > now()) {
                        $fail('Le mandat de cet administrateur n\'est pas encore expiré.');
                    }

                },
            ],
            'appointment_date' => 'string|max:255',
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
