<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Price;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SetProductPriceRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => [
                'required',
                Rule::exists('products', 'id'),
            ],
            'variant_id' => [
                'required',
                Rule::exists('variants', 'id'),
            ],
            'currency' => [
                'required',
                Rule::in(Price::CURRENCIES),
            ],
            'amount' => [
                'required',
                'numeric',
                'integer',
            ]
        ];
    }
}
