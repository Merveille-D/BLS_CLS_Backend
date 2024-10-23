<?php

namespace App\Http\Requests\Shareholder;

use App\Models\Shareholder\Capital;
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

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $actions_number_ask = request()->input('actions_encumbered') + request()->input('actions_no_encumbered');

            $capital = Capital::all();
            if ($capital->isEmpty()) {
                $validator->errors()->add('capital', "Aucun capital n'est encore enregistré  .");
            }else {
                $capital = Capital::latest()->first();
                $action_number = $capital->amount / $capital->par_value;
                $shareholder_total_actions = Shareholder::sum('actions_number');

                if($action_number > $shareholder_total_actions) {

                    $diff = $action_number - $shareholder_total_actions;

                    if($actions_number_ask > $diff) {
                        $validator->errors()->add('actions_number', "Il ne reste que ' . $diff .' actions pour le capital de la banque.");
                    }

                }else {
                    $validator->errors()->add('actions_number', "Il ne reste plus d'action disponible pour le capital de la banque.");
                }
            }

        });
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
