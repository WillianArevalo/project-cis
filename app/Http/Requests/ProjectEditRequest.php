<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectEditRequest extends FormRequest
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
            "benefited_population" => "required|string",
            "general_objective" => "required|string",
            "justification" => "required|string",
            "location" => "required|string",
            "map" => "nullable|image",
            "contextualization" => "required|string",
            "description_activities" => "required|string",
            "projections" => "required|string",
            "challenges" => "required|string",
            "schedule" => "nullable|file|mimes:pdf,doc,docx",
            "specific_objectives" => "nullable|array|min:3",
        ];
    }
}