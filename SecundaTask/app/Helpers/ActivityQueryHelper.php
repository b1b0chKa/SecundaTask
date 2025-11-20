<?php

namespace App\Helpers;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Builder;

class ActivityQueryHelper
{
    public static function findActivity(array $data): ?Activity
    {
        if (!empty($data['activity_id']))
            return Activity::find($data['activity_id']);

        if (!empty($data['activity_name']))
            return Activity::where('name', 'ilike', "%{$data['activity_name']}%")->first();

        return null;
    }


    public static function applyActivityFilter(Builder $query, Activity $activity, bool $includeChildren): Builder
    {
        return $query->whereHas('activities', function (Builder $q) use ($activity, $includeChildren)
        {
            if ($includeChildren)
            {
                $q->whereRaw('path <@ ?', $activity->path);
            }
            else
                $q->where('activity_id', $activity->id);
        });
    }
}