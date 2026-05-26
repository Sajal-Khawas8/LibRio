<?php

namespace App\Http\Requests\Client;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class BookPaymentRequest extends FormRequest
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
            "books" => ["bail", "required", "array"],
            "books.*.id" => [
                "bail",
                "required",
                Rule::exists('quantities', 'book_id')->whereNot('available', 0)
            ],
            "books.*.returnDate" => ["bail", "required", "after_or_equal:today"],
        ];
    }

    public function messages()
    {
        return [
            "books.*.id" => "The book is not available for rent.",
            "books.*.returnDate" => "The return date must be a date after or equal to today."
        ];
    }
}
