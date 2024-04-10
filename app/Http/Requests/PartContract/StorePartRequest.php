<?php

namespace App\Http\Requests\Administrator;

use App\Enums\AdminFunction;
use App\Enums\AdminType;
use App\Enums\Quality;
use App\Models\Contract\Part;
use App\Rules\Administrator\ArrayElementMatch;
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
            'telephone' => 'required|numeric|max:255',
            'residence' => 'required|string|max:255',
            'number_id' => 'required|numeric|max:255',
            'zip_code' => 'required|integer',

            'type' => ['required', Rule::in(Part::TYPES_PART)],

            'denomination' => 'required_if:type,corporate',
            'number_rccm' => 'required_if:type,corporate',
            'number_ifu' => 'required_if:type,corporate',
            'id_card' => 'required_if:type,corporate',
            'capital' => 'required_if:type,corporate',
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
