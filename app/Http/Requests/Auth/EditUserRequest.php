<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
        //edit user request
        $user = $this->route('user');

        return [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|email|unique:users,email,' . $user->id,
            'role_id' => 'required|uuid|exists:roles,id',
            'username' => 'required|string|unique:users,username,' . $user->id,
            'subsidiary_id' => 'required|uuid|exists:countries,id',
        ];
    }
}
