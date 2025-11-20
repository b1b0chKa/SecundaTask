<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class SearchByActivityRequest extends FormRequest
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
            'activity_id'      => ['nullable', 'numeric', 'exists:activities,id'],
            'activity_name'    => ['nullable', 'string', 'max:255'],
            'include_children' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'activity_id.numeric'  => 'Поле activity_id должно быть целым числом.',
            'activity_id.exists'   => 'Деятельности с таким id не существует.',
            'activity_name.string' => 'Поле activity_name должно быть строкой.',
            'activity_name.max'    => 'Поле activity_name не может содержать больше 255 символов.',
            'include_children'     => 'Поле должно быть типа boolean.',
        ];
    }
}
