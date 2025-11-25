<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\SearchByActivityRequest;
use App\Http\Requests\Organization\SearchByBuildingRequest;
use App\Http\Requests\Organization\SearchByNameRequest;
use App\Http\Requests\Organization\SearchNearbyRequest;
use App\Http\Responses\ApiResponse;
use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Organizations",
 *     description="API для работы с организациями"
 * )
 */
class OrganizationController extends Controller
{
    protected OrganizationService $service;

    public function __construct(OrganizationService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/{id}",
     *     tags={"Organizations"},
     *     summary="Получение организации по ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID организации",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Организация найдена",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Организация по введенному ID найдена!"),
     *             @OA\Property(property="data", ref="#/components/schemas/Organization")
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
     *             @OA\Property(property="data", type="array", @OA\Items(), example={}),
     *             @OA\Property(property="error", type="object",
     *                 @OA\Property(property="message", type="string", example="Данные не найдены")
     *             )
     *         )
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $data = $this->service->getById($id);

        return ApiResponse::success($data, 'Организация по введенному ID найдена!');
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/activity",
     *     summary="Получить организации по виду деятельности(Тут указываем либо id активности, либо название активности)",
     *     tags={"Organizations"},
     *     @OA\Parameter(
     *         name="activity_id",
     *         in="query",
     *         required=false,
     *         description="ID деятельности",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="activity_name",
     *         in="query",
     *         required=false,
     *         description="Название деятельности",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="include_children",
     *         in="query",
     *         required=false,
     *         description="Включать дочерние виды деятельности",
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список организаций по выбранной деятельности",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Организации по введенной активности найдены!"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Organization")
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
     *             @OA\Property(property="data", type="array", @OA\Items(), example={}),
     *             @OA\Property(property="error", type="object",
     *                 @OA\Property(property="message", type="string", example="Данные не найдены")
     *             )
     *         )
     *     )
     * )
     */
    public function byActivity(SearchByActivityRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $data = $this->service->getByActivity($validated);

        return ApiResponse::success($data, 'Организации по введенной активности найдены!');
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/building",
     *     tags={"Organizations"},
     *     summary="Получение организаций по зданию ( Нужно указывать либо адрес здания , либо его id)",
     *     @OA\Parameter(
     *         name="building_id",
     *         in="query",
     *         required=false,
     *         description="ID здания",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="address",
     *         in="query",
     *         required=false,
     *         description="Адрес здания",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Организации найдены",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="code", type="integer", example=200),
     *             @OA\Property(property="message", type="string", example="Организации в этом здании найдены!"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Organization"))
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
     *             @OA\Property(property="data", type="array", @OA\Items(), example={}),
     *             @OA\Property(property="error", type="object",
     *                 @OA\Property(property="message", type="string", example="Данные не найдены")
     *             )
     *         )
     *     )
     * )
     */
    public function byBuilding(SearchByBuildingRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $data = $this->service->getByBuilding($validated);

        return ApiResponse::success($data, 'Организации в этом здании найдены!');
    }

    /**
     * @OA\Get(
     *     path="/api/organizations/name",
     *     tags={"Organizations"},
     *     summary="Поиск организации по названию",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=true,
     *         description="Название организации",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Организация найдена",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="code", type="integer"),
     *             @OA\Property(property="message", type="string", example="Организация с введенным названием найдена!"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Organization"))
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
     *             @OA\Property(property="data", type="array", @OA\Items(), example={}),
     *             @OA\Property(property="error", type="object",
     *                 @OA\Property(property="message", type="string", example="Данные не найдены")
     *             )
     *         )
     *     )
     * )
    */
    public function byName(SearchByNameRequest $request): JsonResponse
    {
        $validated = $request->validated()['name'];
  
        $data = $this->service->getByName($validated);

        return ApiResponse::success($data, 'Организация с введенным названием найдена!');
    }

    /**
     * @OA\Post(
     *     path="/api/organizations/geo",
     *     tags={"Organizations"},
     *     summary="Поиск организаций по геоположению",
     *     description="Можно искать организации либо по радиусу относительно точки, либо по прямоугольной области. Нужно указывать параметры только для одного типа поиска.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="latitude",
     *                     type="number",
     *                     format="float",
     *                     description="Широта центра поиска (для радиуса)"
     *                 ),
     *                 @OA\Property(
     *                     property="longitude",
     *                     type="number",
     *                     format="float",
     *                     description="Долгота центра поиска (для радиуса)"
     *                 ),
     *                 @OA\Property(
     *                     property="radius",
     *                     type="number",
     *                     format="float",
     *                     description="Радиус поиска в метрах (для радиуса)"
     *                 ),
     *                 @OA\Property(
     *                     property="lat_min",
     *                     type="number",
     *                     format="float",
     *                     description="Минимальная широта (для прямоугольной области)"
     *                 ),
     *                 @OA\Property(
     *                     property="lat_max",
     *                     type="number",
     *                     format="float",
     *                     description="Максимальная широта (для прямоугольной области)"
     *                 ),
     *                 @OA\Property(
     *                     property="lng_min",
     *                     type="number",
     *                     format="float",
     *                     description="Минимальная долгота (для прямоугольной области)"
     *                 ),
     *                 @OA\Property(
     *                     property="lng_max",
     *                     type="number",
     *                     format="float",
     *                     description="Максимальная долгота (для прямоугольной области)"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Организации найдены",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean"),
     *             @OA\Property(property="code", type="integer"),
     *             @OA\Property(property="message", type="string", example="a"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Organization"))
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
     *             @OA\Property(property="data", type="array", @OA\Items(), example={}),
     *             @OA\Property(property="error", type="object",
     *                 @OA\Property(property="message", type="string", example="Данные не найдены")
     *             )
     *         )
     *      )
     * )
     */
    public function byGeo(SearchNearbyRequest $request): JsonResponse
    {
        $validated = $request->validated();
        
        $data = $this->service->getByGeo($validated);

        return ApiResponse::success($data, 'Организации в данной области найдены!');
    }
}
