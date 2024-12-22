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
            "institution" => "required|string",
            "academic_level" => "required|string",
            "career" => "required|string",
            "study_level" => "required|string",
            "community_id" => "required|exists:communities,id",
            "user_id" => "required|exists:users,id",
        ];
    }
}