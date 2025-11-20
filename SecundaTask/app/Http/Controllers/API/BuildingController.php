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

    public function index(): JsonResponse
    {
        return ApiResponse::success($this->service->getAll(), 'Все здания найдены');
    }
}
