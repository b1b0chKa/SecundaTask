<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class SearchByBuildingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    protected function prepareForValidation()
    {
        $this->merge($this->query());
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'building_id' => ['nullable', 'numeric', 'exists:buildings,id'],
            'address'     => ['nullable', 'string', 'max:255'],
        ];
    }


    public function messages(): array
    {
        return [
            'building_id.numeric' => 'Поле building_id должно быть целым числом.',
            'building_id.exists'  => 'Такого здания не существует.',
            'address.string'      => 'Поле address должно быть строкой.',
            'address.max'         => 'Поле address не может содержать больше 255 символов.',
        ];
    }
}
