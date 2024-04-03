<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
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
            'device_uuid' => 'required|string',
            'product_id' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'device_uuid.required' => 'Device ID alanı boş geçilemez.',
            'device_uuid.string' => 'Device ID alanı sadece metinsel ifade içerebilir.',
            'product_id.required' => 'Product ID alanı boş geçilemez.',
            'product_id.string' => 'Product ID alanı sadece metinsel ifade içerebilir.'
        ];
    }
}
