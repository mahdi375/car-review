<?php

namespace App\Http\Requests\Api\V1\Car;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'brand_id' => ['required', 'exists:brands,id'],
            'model' => ['required', 'string', 'min:3', 'max:254'],
            'color' => ['required', 'string', 'min:3', 'max:254'],
        ];
    }
}
