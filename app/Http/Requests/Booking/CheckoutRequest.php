<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
  public function authorize(): bool
  {
    return auth()->check();
  }

  public function rules(): array
  {
    return [
      'booking_for'    => 'required|string|in:me,others',
      'comment'        => 'nullable|string|max:500',
      'is_used_coupon' => 'required|boolean',
      'resort_id'      => 'required|integer|exists:resorts,id',
      'room_id'        => 'required|integer|exists:rooms,id',
      'adult'          => 'required|integer|min:1',
      'child'          => 'nullable|integer|min:0',
      'start_date'     => 'required|date',
      'end_date'       => 'required|date|after_or_equal:start_date',
      'amount'         => 'required|numeric|min:0',
    ];
  }

  public function messages(): array
  {
    return [
      'booking_for.required' => 'Please specify who you are booking for.',
      'resort_id.exists' => 'The selected resort is invalid.',
      'room_id.exists' => 'The selected room is invalid.',
    ];
  }
}
