<?php

namespace App\Http\Requests\Hypothec;

use App\Concerns\Traits\Guarantee\StepsValidationRuleTrait;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CompleteTaskRequest extends FormRequest
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
        throw new HttpResponseException(api_error(false, $validator->errors()->first(),  $validator->errors()));
        // throw new HttpResponseException(response()->json(['success' => false, 'errors' => $validator->errors()], 422));
    }
}
