<?php

namespace App\Helpers;

use Clickbar\Magellan\Data\Geometries\Point;
use Clickbar\Magellan\Database\PostgisFunctions\ST;
use Illuminate\Database\Eloquent\Builder;

class GeoHelper
{
    public static function searchByRadius(Builder $query, float $lat, float $lng, float $radius): Builder
    {
        $center = Point::makeGeodetic($lat, $lng);

        $query->whereHas('building', function (Builder $q) use($center, $radius)
        {
            $q->where(ST::distanceSphere('location', $center), '<=', $radius);
        });

        return $query;
    }

    public static function searchByRectangle(Builder $query, float $minLat, float $maxLat, float $minLng, float $maxLng): Builder
    {
        $query->whereHas('building', function (Builder $q) use ($minLat, $maxLat, $minLng, $maxLng)
        {
            $q->whereBetween(ST::x('location'), [$minLng, $maxLng])
                ->whereBetween(ST::y('location'), [$minLat, $maxLat]);
        });

        return $query;
    }
}