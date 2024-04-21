<?php

namespace App\Http\Requests\Recovery;

use App\Enums\Recovery\RecoveryStepEnum;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProcessRequest extends FormRequest
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
        $model = $this->route('recovery');

        $validationRules = $this->validationRulesByStep($model->status);

        return $validationRules;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['success' => false, 'message' => 'Une erreur s\'est produite', 'errors' => $validator->errors()], 422));
    }

    public function validationRulesByStep($state): array
    {
        $data = array(
            'documents' => 'array|required',
            'documents.*.name' => 'required|string',
            'documents.*.file' => 'required|file|max:8192|mimes:pdf,doc,docx',
        );
        switch ($state) {

            case RecoveryStepEnum::CREATED:
                $data = $data;
                break;
            case RecoveryStepEnum::FORMALIZATION:
                $data = $data;
            case RecoveryStepEnum::FORMAL_NOTICE:
                $data = ['payement_status' => 'required|boolean'];
            case RecoveryStepEnum::DEBT_PAYEMENT:
                $data = $data;
                break;
            case RecoveryStepEnum::JURISDICTION:
                $data = ['is_seized' => 'required|boolean'];
                break;
            case RecoveryStepEnum::SEIZURE:
                $data = $data;
                break;
            case RecoveryStepEnum::EXECUTORY:
                $data = ['is_entrusted' => 'required|boolean'];
                break;
            case RecoveryStepEnum::ENTRUST_LAWYER:
                $data = $data;
                break;

            default:
                break;
        }

        return $data;
    }
}
