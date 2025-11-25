<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Phone",
 *     type="object",
 *     title="Телефон организации",
 *     description="Модель телефона, связанного с организацией",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="organization_id", type="integer", example=1),
 *     @OA\Property(property="phone", type="string", example="8-800-464-7157"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-11-20T23:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-11-20T23:00:00.000000Z")
 * )
 */
class Phone extends Model
{
    /** @use HasFactory<\Database\Factories\PhoneFactory> */
    use HasFactory;

    protected $table = 'organization_phones';

    protected $fillable = [
        'oranization_id',
        'phone',
    ];


    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
