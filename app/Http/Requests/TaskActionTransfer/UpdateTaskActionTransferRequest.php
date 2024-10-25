<?php

namespace App\Http\Requests\TaskActionTransfer;

use App\Models\Shareholder\TaskActionTransfer;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class UpdateTaskActionTransferRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        $rules = [];

        if (! $request->has('type')) {
            $rules['type'] = 'required';
        } else {
            $task = searchElementIndice(TaskActionTransfer::TASKS, $request->input('type'));
            $rules = $task['rules'];
            $rules['task_action_transfer_id'] = ['required', 'uuid'];
        }

        // For Transfer
        $rules['forward_title'] = ['string', 'required_with_all:deadline_transfer,description,collaborators'];
        $rules['deadline_transfer'] = ['date', 'required_with_all:forward_title,description,collaborators'];
        $rules['description'] = ['string', 'required_with_all:forward_title,deadline_transfer,collaborators'];
        $rules['collaborators'] = ['required_with_all:forward_title,deadline_transfer,description', 'array'];
        $rules['collaborators.*'] = ['required_with_all:forward_title,deadline_transfer,description', 'uuid'];

        return $rules;
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
