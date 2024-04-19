<?php

namespace App\Http\Requests\Litigation;

use App\Enums\Litigation\PartyCategory;
use App\Enums\Litigation\PartyType;
use App\Rules\Administrator\ArrayElementMatch;
use Illuminate\Foundation\Http\FormRequest;

class AddPartyRequest extends FormRequest
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
            'name' => 'required',
            // 'category' => ['required', new ArrayElementMatch(PartyCategory::CATEGORIES)],
            'type' => ['required', new ArrayElementMatch(['legal', 'individual'])],
            'address' => 'required',
            'phone' => 'required|numeric',
            'email' => 'required|email',
        ];
    }
}
