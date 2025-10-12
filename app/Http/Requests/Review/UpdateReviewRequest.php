<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
  public function authorize()
  {

    return auth()->check();
  }

  public function rules()
  {
    return [
      'star' => 'required|integer|min:1|max:5',
      'comment' => 'required|string|max:1000',
    ];
  }

  public function messages()
  {
    return [
      'star.required' => 'Star is required',
      'star.integer' => 'Star must be an integer',
      'star.min' => 'Star must be at least 1',
      'star.max' => 'Star cannot exceed 5',
      'comment.required' => 'Comment is required',
      'comment.string' => 'Comment must be a string',
      'comment.max' => 'Comment cannot exceed 1000 characters',
    ];
  }
}
