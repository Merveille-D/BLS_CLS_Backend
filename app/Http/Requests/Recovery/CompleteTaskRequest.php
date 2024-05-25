<?php

namespace App\Http\Requests\Recovery;

use App\Concerns\Traits\Guarantee\StepsValidationRuleTrait;
use App\Enums\Recovery\RecoveryStepEnum;
use App\Rules\Administrator\ArrayElementMatch;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CompleteTaskRequest extends FormRequest
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
        $task = $this->route('task');

        if ($task->status) {
            throw new HttpResponseException(api_error(false, 'Cette tâche est déjà complétée',  []));
        } elseif ($task->type == 'task') {
            return [];
        }

        $validationRules = $this->validationRulesByStep($task?->taskable?->state);

        return $validationRules;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(api_error(false, $validator->errors()->first(),  $validator->errors(), 422));
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
                $data = [
                    'payement_status' => ['required', new ArrayElementMatch(array('yes', 'no'))],
                ];

            case RecoveryStepEnum::DEBT_PAYEMENT:
                $data = $data;
                break;
            case RecoveryStepEnum::JURISDICTION:
                $data = [
                    'is_seized' => ['required', new ArrayElementMatch(array('yes', 'no'))],
                ];
                break;
            case RecoveryStepEnum::SEIZURE:
                $data = $data;
                break;
            case RecoveryStepEnum::EXECUTORY:
                $data = [
                    'is_entrusted' => ['required', new ArrayElementMatch(array('yes', 'no'))],
                ];
                break;
            case RecoveryStepEnum::ENTRUST_LAWYER:
                $data = $data;
                break;

            default:
                break;
        }

        return $data;
    }

    public function validationRulesByStepNew($task) : array {

        $form = $task->form ?? [];
        $data = [];

        if (!blank($form)) {
            $fields = $form['fields'];

            foreach ($fields as $field) {
                if ($field['type'] == 'file') {
                    $data['documents'] = 'array|required';
                    $data['documents.*.name'] = 'required|string';
                    $data['documents.*.file'] = 'required|file|max:8192|mimes:pdf,doc,docx';
                }

                if ($field['type'] == 'date') {
                    $data[$field['name']] = 'required|date|date_format:Y-m-d';
                }

                if ($field['type'] == 'select') {
                    $data[$field['name']] = 'required|string';
                }

                if ($field['type'] == 'radio') {
                    $data[$field['name']] = ['required', new ArrayElementMatch(array('yes', 'no'))];
                }


            }
        }

        return $data;
    }
}
