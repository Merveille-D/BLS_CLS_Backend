<?php

namespace App\Http\Requests\Litigation;

use Illuminate\Foundation\Http\FormRequest;

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
            'nature_id' => 'required|exists:litigation_resources,id',
            'jurisdiction_id' => 'required|exists:litigation_resources,id',
            'party_id' => 'required|exists:litigation_parties,id',
            'documents' => 'array|required',
            'documents.*.name' => 'required|string',
            'documents.*.file' => 'required|file|max:8192|mimes:pdf,doc,docx',
        ];
    }
}
