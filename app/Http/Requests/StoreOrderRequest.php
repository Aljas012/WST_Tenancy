<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'orders' => ['required', 'array'],
            'orders.*.part_number' => ['required', 'string'],
            'orders.*.quantity' => ['required', 'integer', 'min:1'],
            'orders.*.total' => ['required', 'numeric', 'min:0'],
            'car_id' => ['required', 'exists:maintenances,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'car_id.required' => 'No selected Maintenance.',
            'car_id.exists' => 'The selected maintenance does not exist..',
        ];
    }
}
