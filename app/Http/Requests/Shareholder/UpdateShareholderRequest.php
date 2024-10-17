<?php

namespace App\Http\Requests\Shareholder;

use App\Models\Shareholder\Shareholder;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateShareholderRequest extends FormRequest
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
            'name' => ['string'],
            'type' => [ Rule::in(Shareholder::TYPES) ],
            'nationality' => 'string|max:255',
            'address' => 'string|max:255',
            'corporate_type' => [Rule::in(Shareholder::CORPORATE_TYPES) ],
            'actions_encumbered' => ['required', 'numeric', 'gt:0'],
            'actions_no_encumbered' => ['required', 'numeric', 'gt:0'],
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
