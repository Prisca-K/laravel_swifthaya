<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'required_skills' => 'nullable|string',
      'budget' => 'nullable|numeric|min:0',
      'duration' => 'nullable|integer|min:1',
      'deadline_date' => 'nullable|date|after_or_equal:posted_at',
    ];
  }
}
