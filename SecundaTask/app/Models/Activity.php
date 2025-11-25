<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Activity",
 *     type="object",
 *     title="Деятельность",
 *     description="Модель деятельности организации",
 *     @OA\Property(property="id", type="integer", example=2),
 *     @OA\Property(property="name", type="string", example="Еда"),
 *     @OA\Property(property="parent_id", type="integer", nullable=true, example=1),
 *     @OA\Property(property="path", type="string", example="1.2"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-11-20T23:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-11-20T23:00:00.000000Z"),
 *     @OA\Property(
 *         property="pivot",
 *         type="object",
 *         description="Сведения о связующей таблице между организацией и деятельностью",
 *         @OA\Property(property="organization_id", type="integer", example=1),
 *         @OA\Property(property="activity_id", type="integer", example=2)
 *     )
 * )
 */
class Activity extends Model
{
    /** @use HasFactory<\Database\Factories\ActivityFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'parent_id',
        'path',
    ];


    public function children()
    {
        return $this->hasMany(Activity::class, 'parent_id');
    }
    
    
    public function parent()
    {
        return $this->belongsTo(Activity::class, 'parent_id');
    }


    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'activity_organization');
    }
}
