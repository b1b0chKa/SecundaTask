<?php

namespace App\Services;

use App\Models\Building;
use Illuminate\Support\Collection;

class BuildingService
{
    public function getAll(): Collection
    {
        return Building::all();
    }
}
