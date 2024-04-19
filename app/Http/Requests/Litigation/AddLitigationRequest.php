<?php

namespace App\Http\Requests\Litigation;

use App\Enums\Litigation\PartyCategory;
use App\Enums\Litigation\PartyType;
use App\Rules\Administrator\ArrayElementMatch;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddLitigationRequest extends FormRequest
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
            'reference' => 'nullable',
            'nature_id' => 'required|exists:litigation_settings,id',
            'jurisdiction_id' => 'required|exists:litigation_settings,id',
            'jurisdiction_location' => 'required',
            'parties' =>  'array|required',
            'parties.*.category' => ['required', new ArrayElementMatch(PartyCategory::CATEGORIES)],
            'parties.*.type' =>  ['required', new ArrayElementMatch(PartyType::TYPES)],
            'parties.*.party_id' =>  'required|exists:litigation_parties,id',
            'documents' => 'array|required',
            'documents.*.name' => 'required|string',
            'documents.*.file' => 'required|file|max:8192|mimes:pdf,doc,docx',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(api_error(false, $validator->errors()->first(),  $validator->errors()));
    }
}
