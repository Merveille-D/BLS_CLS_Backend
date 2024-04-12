<?php

namespace App\Http\Requests\ActionTransfer;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateActionTransferRequest extends FormRequest
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
            'owner_id' => 'numeric',
            'buyer_id' => 'numeric',
            'count_actions' => 'integer',
            'lastname' => 'string',
            'firstname' => 'string',

            'response_agrement' => 'boolean',
            'file_agrement_ca' => ['required_if:buyer_id,true', 'file'],
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
