<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BecadoRequest extends FormRequest
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
            "name" => "required|string",
            "photo" => "nullable|image",
            "institution" => "nullable|string",
            "academic_level" => "nullable|string",
            "career" => "nullable|string",
            "study_level" => "nullable|string",
            "community_id" => "required|exists:communities,id",
            "user_id" => "nullable|exists:users,id",
            "user" => "nullable|string",
            "phone" => "nullable|string",
        ];
    }
}
