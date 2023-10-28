<?php

namespace App\Http\Requests\Api\V1\Review;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'car_id' => ['required', 'exists:cars,id'],
            'star' => ['required', 'integer', 'min:0', 'max:10'],
            'review' => ['nullable', 'string', 'min:3', 'max:2040'],
        ];
    }
}
