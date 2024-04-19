<?php

namespace App\Http\Requests\Litigation;

use App\Enums\Litigation\PartyCategory;
use App\Enums\Litigation\PartyType;
use App\Rules\Administrator\ArrayElementMatch;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddPartyRequest extends FormRequest
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
            'name' => 'required',
            // 'category' => ['required', new ArrayElementMatch(PartyCategory::CATEGORIES)],
            'type' => ['required', new ArrayElementMatch(['legal', 'individual'])],
            'address' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(api_error(false, $validator->errors()->first(),  $validator->errors()));
    }
}
