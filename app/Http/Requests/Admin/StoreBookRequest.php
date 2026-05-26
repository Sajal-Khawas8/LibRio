<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookRequest extends FormRequest
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
            "title" => ["bail", "required", "regex:/^[a-zA-Z\s\d&()-]*$/", "min:3", "max:50", Rule::unique("books", "title")->ignore($this->route("book"))->whereNull("deleted_at")],
            "author" => ["bail", "required", "regex:/^[a-zA-Z\s.]*$/", "min:3", "max:50"],
            "category" => ["bail", "required", "exists:categories,id"],
            "copies" => ["bail", "required", "integer"],
            "rent" => ["bail", "required", "decimal:0,2"],
            "fine" => ["bail", "required", "decimal:0,2"],
            "cover" => ["bail", $this->route('book') ? "nullable" : "required", "image"],
            "description" => ["bail", "required", "min:3"]
        ];
    }
}
