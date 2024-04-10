<?php

namespace App\Http\Requests\PartContract;

use App\Models\Contract\Part;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StorePartRequest extends FormRequest
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
            'email' => 'required|email',
            'telephone' => 'required|numeric',
            'residence' => 'required|string|max:255',
            'number_id' => 'required|numeric',
            'zip_code' => 'required|numeric',

            'type' => ['required', Rule::in(Part::TYPES_PART)],

            'denomination' => 'required_if:type,corporate',
            'number_rccm' => 'required_if:type,corporate|numeric',
            'number_ifu' => 'required_if:type,corporate|numeric',
            'id_card' => 'required_if:type,corporate|numeric',
            'capital' => 'required_if:type,corporate|numeric',
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
