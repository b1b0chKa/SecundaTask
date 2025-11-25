<?php

namespace App\Http\Requests\Organization;

use Illuminate\Foundation\Http\FormRequest;

class SearchNearbyRequest extends FormRequest
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
            // поля для поиска по радиусу
            'latitude'  => ['required_without_all:lat_min,lat_max,lng_min,lng_max', 'numeric'],
            'longitude' => ['required_without_all:lat_min,lat_max,lng_min,lng_max', 'numeric'],
            'radius'    => ['nullable', 'numeric', 'min:0'],

            // поля для поиска по прямоугольнику
            'lat_min' => ['required_without_all:latitude,longitude,radius', 'numeric'],
            'lat_max' => ['required_without_all:latitude,longitude,radius', 'numeric'],
            'lng_min' => ['required_without_all:latitude,longitude,radius', 'numeric'],
            'lng_max' => ['required_without_all:latitude,longitude,radius', 'numeric'],
        ];
    }


    protected function prepareForValidation()
    {
        $this->replace($this->only([
            'latitude', 'longitude', 'radius',
            'lat_min', 'lat_max', 'lng_min', 'lng_max'
        ]));
    }


    public function messages(): array
    {
        return [
            'latitude.required_without_all' => 'Укажите начальную точку для поиска (latitude и longitude) или границы прямоугольника.',
            'longitude.required_with'       => 'Укажите longitude вместе с latitude.',
            'lat_min.required_without_all'  => 'Укажите границы прямоугольника (lat_min / lat_max и lng_min / lng_max) или точку для поиска.',
            'lat_max.required_with'         => 'Укажите lat_max вместе с lat_min.',
            'lng_min.required_with'         => 'Укажите lng_min вместе с lat_min.',
            'lng_max.required_with'         => 'Укажите lng_max вместе с lat_min.',
        ];
    }
}
