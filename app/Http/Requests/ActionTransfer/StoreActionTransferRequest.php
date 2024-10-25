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
            'type' => ['required',  Rule::in(ActionTransfer::TYPES)],
            'owner_id' => 'required|uuid',
            'buyer_id' => [
                'uuid',
                function ($attribute, $value, $fail) {
                    if (empty(request()->input('name')) && empty(request()->input('grade'))) {
                        if (empty($value)) {
                            $fail('The ' . $attribute . ' field is required when type is tier and both name and grade are not provided.');
                        }
                    }
                },
            ],
            'count_actions' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($actions_no_encumbered_owner) {
                    if ($value > $actions_no_encumbered_owner) {
                        $fail('Le nombre d\'actions à transférer doit etre inférieur ou égal au nombre d\'actions non grevée du cédant.');
                    }
                },
            ],
            'transfer_date' => ['required', 'date'],

            'name' => [
                'string',
                // function ($attribute, $value, $fail) {
                //     if (request()->input('type') === 'tier' && request()->input('buyer_id') === null) {
                //         if (empty($value)) {
                //             $fail('The ' . $attribute . ' field is required when type is tier and tier_id is null.');
                //         }
                //     }
                // },
            ],
            'grade' => [
                'string',
                // function ($attribute, $value, $fail) {
                //     if (request()->input('type') === 'tier' && request()->input('buyer_id') === null) {
                //         if (empty($value)) {
                //             $fail('The ' . $attribute . ' field is required when type is tier and tier_id is null.');
                //         }
                //     }
                // },
            ],
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
