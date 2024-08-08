<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSwifthayajobRequest extends FormRequest
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
      'location' => 'nullable|string|max:255',
      'salary_range' => 'nullable|string|max:255',
      'job_type' => 'required|in:Full-time,Part-time,Contract',
      'posted_at' => 'nullable|date',
      'deadline_date' => 'nullable|date|after_or_equal:posted_at',
    ];
  }
}
