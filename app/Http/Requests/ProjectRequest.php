<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            "community_id" => "required|integer|exists:communities,id",
            "document" => "nullable|file|mimes:pdf,doc,docx",
            "benefited_population" => "nullable|string",
            "general_objective" => "nullable|string",
            "justification" => "nullable|string",
            "location" => "nullable|string",
            "map" => "nullable|image",
            "contextualization" => "nullable|string",
            "description_activities" => "nullable|string",
            "projections" => "nullable|string",
            "challenges" => "nullable|string",
            "schedule" => "nullable|file|mimes:pdf,doc,docx",
            "specific_objectives" => "nullable|array|min:1",
            "scholarship_id" => "nullable|string",
        ];
    }
}
