<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchResortRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'resort_id' => 'required|integer',
      'check_in' => 'required|date',
      'check_out' => 'required|date|after:check_in',
      'rooms' => 'required|json',
    ];
  }

  public function messages(): array
  {
    return [
      'resort_id.required' => 'Please select a resort.',
      'check_in.required' => 'Check-in date is required.',
      'check_out.required' => 'Check-out date is required.',
      'check_out.after' => 'Check-out date must be after check-in date.',
      'rooms.required' => 'Please select at least one room.',
    ];
  }
}
