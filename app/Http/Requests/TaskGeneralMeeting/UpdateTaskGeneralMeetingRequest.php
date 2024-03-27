<?php

namespace App\Http\Requests\TaskGeneralMeeting;

use App\Models\Gourvernance\GeneralMeeting\TaskGeneralMeeting;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateTaskGeneralMeetingRequest extends FormRequest
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
        $rules = [
            'libelle' => ['required', 'string'],
            'type' => ['required', Rule::in(TaskGeneralMeeting::MEETING_TASK_TYPE)],
        ];

        if ($this->input('type') === 'post_ag') {
            $rules['responsible'] = ['required', 'string'];
            $rules['deadline'] = ['required', 'date'];
            $rules['supervisor'] = ['required', 'string'];
        }

        return $rules;
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
