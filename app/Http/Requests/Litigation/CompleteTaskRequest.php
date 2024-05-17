<?php

namespace App\Http\Requests\Litigation;

use App\Concerns\Traits\Guarantee\StepsValidationRuleTrait;
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


        $validationRules = $this->validationRulesByStep($task);

        return $validationRules;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(api_error(false, $validator->errors()->first(),  $validator->errors(), 422));
    }

    public function validationRulesByStep($task) : array {

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

                if ($field['type'] == 'text') {
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
