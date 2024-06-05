<?php

namespace App\Http\Requests\ActionTransfer;

use App\Models\Shareholder\ActionTransfer;
use App\Models\Shareholder\Shareholder;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreActionTransferRequest extends FormRequest
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
        $actions_no_encumbered_owner = Shareholder::find(request()->input('owner_id'))->actions_no_encumbered;

        return [
            'type' => ['required',  Rule::in(ActionTransfer::TYPES) ],
            'owner_id' => 'required|uuid',
            'buyer_id' => ['required_if:type,shareholder', 'uuid'],
            'tier_id' => ['required_if:type,tier', 'uuid'],
            'count_actions' => [
                'required',
                'numeric',
                function($attribute, $value, $fail) use ($actions_no_encumbered_owner) {
                    if ($value > $actions_no_encumbered_owner) {
                        $fail('Le nombre d\'actions à transférer doit etre inférieur ou égal au nombre d\'actions non grevée du cédant.');
                    }
                },
            ],
            'transfer_date' => ['required', 'date'],

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
