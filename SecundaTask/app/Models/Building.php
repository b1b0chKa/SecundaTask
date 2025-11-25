<?php

namespace App\Models;

use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Building",
 *     type="object",
 *     title="Здание",
 *     description="Модель здания с адресом, геопозицией и организациями",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="address", type="string", example="930878, Кировская область, город Красногорск, пер. Ломоносова, 67"),
 *     @OA\Property(
 *         property="location",
 *         type="object",
 *         description="Географическая точка в формате GeoJSON",
 *         @OA\Property(property="type", type="string", example="Point"),
 *         @OA\Property(
 *             property="coordinates",
 *             type="array",
 *             description="Координаты [долгота, широта]",
 *             @OA\Items(type="number", example={-29.036194, -14.029256})
 *         )
 *     ),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-11-20T23:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-11-20T23:00:00.000000Z"),
 * )
 */
class Building extends Model
{
    /** @use HasFactory<\Database\Factories\BuildingFactory> */
    use HasFactory;

    protected $fillable = [
        'address',
        'location',
    ];

    protected $casts = [
        'location' => Point::class,
    ];

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }
}
