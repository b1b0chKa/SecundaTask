<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
