<?php

namespace App\Http\Requests\Hypothec;

use App\Concerns\Traits\Guarantee\StepsValidationRuleTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProcessRequest extends FormRequest
{
    use StepsValidationRuleTrait;
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
        $model = $this->route('convHypo');
        $validationRules = $this->validationRulesByStep($model->state);

        return $validationRules;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(api_error(false, $validator->errors()->first(),  $validator->errors()));
        // throw new HttpResponseException(response()->json(['success' => false, 'errors' => $validator->errors()], 422));
    }
}
