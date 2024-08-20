<?php

namespace App\Http\Requests\Shareholder;

use App\Models\Shareholder\Capital;
use App\Models\Shareholder\Shareholder;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreShareholderRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'type' => ['required',  Rule::in(Shareholder::TYPES) ],
            'nationality' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'corporate_type' => ['required_if:type,corporate', Rule::in(Shareholder::CORPORATE_TYPES) ],
            'actions_encumbered' => ['required', 'numeric'],
            'actions_no_encumbered' => ['required', 'numeric'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $capital = Capital::all();

            if ($capital->isEmpty()) {
                $validator->errors()->add('capital', "Aucun capital n'est encore enregistré  .");
            }

            $capital = Capital::get()->last();
            $action_number = $capital->amount / $capital->par_value;
            $shareholder_total_actions = Shareholder::sum('actions_number');

            if($shareholder_total_actions > $action_number) {
                $diff = $shareholder_total_actions - $action_number;
                $validator->errors()->add('actions_number', "Il ne reste que ' . $diff .' actions pour le capital de la banque.");
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
