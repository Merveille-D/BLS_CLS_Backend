<?php

namespace App\Http\Requests\TaskContract;

use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateTaskContractRequest extends FormRequest
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
        $rules = [
            'libelle' => ['string'],
            'deadline' => ['date'],

            // For Transfer
            'forward_title' => ['string', 'required_with_all:deadline_transfer,description,collaborators'],
            'deadline_transfer' => ['date', 'required_with_all:forward_title,description,collaborators'],
            'description' => ['string', 'required_with_all:forward_title,deadline_transfer,collaborators'],
            'collaborators' => ['required_with_all:forward_title,deadline_transfer,description','array'],
            'collaborators.*' => ['required_with_all:forward_title,deadline_transfer,description','uuid'],
        ];

        if (request()->input('status') === true && request()->input('type') === 'milestone') {
            $rules['date'] = ['required', 'date'];
            $rules['documents'] = ['required', 'array'];
            $rules['documents.*.name'] = ['required', 'string'];
            $rules['documents.*.file'] = ['required', 'file'];
        }

        return $rules;
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
