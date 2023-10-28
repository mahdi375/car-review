<?php

namespace App\Http\Requests\Api\V1\Car;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'brand_id' => ['exists:brands,id'],
            'model' => ['string', 'min:1', 'max:254'],
            'color' => ['string', 'min:1', 'max:254'],
        ];
    }
}
