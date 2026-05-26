<?php

namespace App\Http\Requests\Client;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["bail", "required", "min:3", "max:50", "regex:/^[a-zA-Z\s]*$/"],
            "email" => ["bail", "required", "email", Rule::unique("users", "email")->ignore(auth()->user())],
            "profilePicture" => ['nullable', 'image'],
            "address" => ["required", "string", ],
            "current_password" => ["bail", "required", "current_password"],
            "password" => ["bail", "required", Password::min(8)->mixedCase()->numbers()->symbols()->rules(["max:16"])]
        ];
    }
}
