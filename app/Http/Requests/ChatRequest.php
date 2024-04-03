<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatRequest extends FormRequest
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
            'chat_uuid' => 'required|string',
            'message' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'device_uuid.required' => 'Device ID alanı boş geçilemez.',
            'device_uuid.string' => 'Device ID alanı sadece metinsel ifade içerebilir.',
            'chat_uuid.required' => 'Chat ID alanı boş geçilemez.',
            'chat_uuid.string' => 'Chat ID alanı sadece metinsel ifade içerebilir.',
            'message.required' => 'Mesaj alanı boş geçilemez.',
            'message.string' => 'Mesaj alanı sadece metinsel ifade içerebilir.'
        ];
    }
}
