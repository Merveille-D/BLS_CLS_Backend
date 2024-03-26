<?php

namespace App\Http\Requests;

use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateGeneralMeetingRequest extends FormRequest
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
            'general_meeting_id' => ['required', 'numeric'],
            'docs' => ['required', 'array'],
            'docs.files.*' => ['required', 'file'],
            'docs.others_files.*.file' => ['required', 'file'],
            'docs.others_files.*.name' => ['required', 'string'],
            'status' => [Rule::in(GeneralMeeting::GENERAL_MEETING_STATUS) ],
        ];
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
