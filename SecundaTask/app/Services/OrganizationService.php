<?php

namespace App\Services;

use App\Helpers\ActivityQueryHelper;
use App\Helpers\GeoHelper;
use App\Models\Organization;
use Illuminate\Support\Collection;

class OrganizationService
{
    protected $relations = ['building', 'phones', 'activities'];

    protected function withRelations($query)
    {
        return $query->with($this->relations);
    }


    public function getByBuilding(array $data): Collection
    {
        $query = $this->withRelations(Organization::query());

        if(!empty($data['building_id']))
            return $query->where('id', $data['building_id'])->get();

        if (!empty($data['address']))
        {
            return $query->whereHas('building', fn($q) => 
                $q->where('address', 'ilike', "%{$data['address']}%")	
            )->get();
        }
        else
            return collect();
    }


    public function getByActivity(array $data): Collection
    {
        $query = $this->withRelations(Organization::query());
        $activity = ActivityQueryHelper::findActivity($data);

        if (!$activity)
            return collect();

        $query = ActivityQueryHelper::applyActivityFilter($query, $activity, $data['include_children'] ?? false);

        return $query->get();
    }


    public function getByGeo(array $data): Collection
    {
        $query = $this->withRelations(Organization::query());

        if (isset($data['latitude']) || isset($data['longitude']) || isset($data['radius']))
            return GeoHelper::searchByRadius($query, $data['latitude'], $data['longitude'], $data['radius'])->get();
        else if (isset($data['lat_min']) || isset($data['lat_max']) || isset($data['lng_min']) || isset($data['lng_max']))
            return GeoHelper::searchByRectangle($query, $data['lat_min'], $data['lat_max'], $data['lng_min'], $data['lng_max'])->get();

        return collect();
    }


    public function getById(int $id): ?Organization
    {
        return $this->withRelations(Organization::query())
            ->find($id);
    }


    public function getByName(string $name): Collection
    {
        return $this->withRelations(Organization::query())
            ->where('name', 'ilike', "%{$name}%")
            ->get();
    }
}