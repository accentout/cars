<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetAvailableCarsRequest extends FormRequest
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
            'car_model_id' => 'nullable|integer|exists:car_models,id',
            'car_comfort_category_id' => 'nullable|integer|exists:car_comfort_categories,id',
            'start_time' => 'required|date_format:Y-m-d\TH:i:s',
            'end_time' => 'required|date_format:Y-m-d\TH:i:s|after:start_time',
        ];
    }
}
