<?php

namespace App\Http\Requests\Resort;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
  public function authorize()
  {
    return auth()->check();
  }

  public function rules()
  {
    return [
      'resort_id' => 'required|exists:resorts,id',
      'rating'    => 'required|integer|min:1|max:5',
      'comment'   => 'required|string|max:1000',
    ];
  }
}
