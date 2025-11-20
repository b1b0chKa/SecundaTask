<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class ApiResponse extends JsonResponse
{
    public static function success($data, ?string $message = null, int $code = 200): self
    {
        if (is_null($data) || (is_array($data) && empty($data)) || ($data instanceof Collection && $data->isEmpty()))
            return self::error(404, 'Данные не найдены');

        $payload = [
            'status'    => true,
            'code'      => $code,
            'message'   => $message ?? 'Успешно',
            'data'      => $data,
        ];

        return new self($payload, $code);
    }

    
    public static function error(int $code, string $message = 'Данные не найдены'): self
    {
        $payload = [
            'status'    => false,
            'code'      => $code,
            'data'      => [],
            'error'     => [
                'message' => $message,
            ],
        ];

        return new self($payload, $code);
    }
}
