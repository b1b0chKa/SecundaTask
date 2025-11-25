<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Organization",
 *     type="object",
 *     title="Организация",
 *     description="Модель организации с вложенными связями",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="ПАО МоторЭлектроТранс"),
 *     @OA\Property(property="building_id", type="integer", example=1),
 *     @OA\Property(property="office_number", type="string", example="81"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-11-20T23:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-11-20T23:00:00.000000Z"),
 *
 *     @OA\Property(
 *         property="building",
 *         ref="#/components/schemas/Building"
 *     ),
 *
 *     @OA\Property(
 *         property="phones",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Phone")
 *     ),
 *
 *     @OA\Property(
 *         property="activities",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Activity")
 *     )
 * )
 */
class Organization extends Model
{
    /** @use HasFactory<\Database\Factories\OrganizationFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'buildung_id',
        'office_number',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function phones()
    {
        return $this->hasMany(Phone::class); 
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_organization');
    }
}
