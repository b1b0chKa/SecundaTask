<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Services\BuildingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    protected $service;

    public function __construct(BuildingService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/buildings",
     *     summary="Получить список всех зданий",
     *     description="Возвращает все здания с адресом и координатами",
     *     tags={"Buildings"},
     *     security={{"api_key": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Список всех зданий успешно получен",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Все здания найдены"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Building")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Не передан или неверный API ключ",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="code", type="integer", example=401),
     *             @OA\Property(property="error", type="object",
     *                 @OA\Property(property="message", type="string", example="Не передан API ключ")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Данные не найдены",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="code", type="integer", example=404),
     *             @OA\Property(property="data", type="array", @OA\Items()),
     *             @OA\Property(property="error", type="object",
     *                 @OA\Property(property="message", type="string", example="Данные не найдены")
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return ApiResponse::success($this->service->getAll(), 'Все здания найдены');
    }
}
