<?php

namespace App\Http\Requests\Watch;

use App\Enums\Watch\WatchType;
use App\Rules\Administrator\ArrayElementMatch;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class AddWatchRequest extends FormRequest
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
        // dd(request('is_archived'));
        return [
            'name' => 'required|string|max:255',
            'reference' => 'nullable|string|max:255',
            'type' => ['required', new ArrayElementMatch(WatchType::TYPES)],
            'summary' => 'required|string',
            'innovation' => 'required|string',
            'is_archived' => 'boolean',
            'event_date' => 'nullable|date',
            'effective_date' => 'nullable|date',
            'nature_id' => 'nullable|exists:litigation_resources,id',
            'jurisdiction_id' => 'nullable|exists:litigation_resources,id',
            // 'recipient_type' => 'required_if:is_archived,false',

            'recipient_type' =>  ['required_if:is_archived,false', new ArrayElementMatch(array('admin', 'persoonel'))],
            'mail_object' =>'required_if:is_archived,false',
            'mail_content' => 'required_if:is_archived,false',
            'mail_addresses' => 'required_if:is_archived,false',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(api_error(false, $validator->errors()->first(),  $validator->errors()));
    }
}
