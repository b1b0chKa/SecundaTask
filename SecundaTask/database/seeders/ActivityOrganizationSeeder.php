<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Organization;
use Illuminate\Container\Attributes\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as FacadesDB;

class ActivityOrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activityIds = Activity::pluck('id');
        $organizationIds = Organization::pluck('id')->toArray();

        $pivotData = [];

        foreach($organizationIds as $orgId)
        {
            $randActivityIds = $activityIds->random(rand(1,2))->toArray();

            foreach($randActivityIds as $activityId)
            {
                $pivotData[] = [
                    'organization_id'   => $orgId,
                    'activity_id'       => $activityId,
                ];
            }
        }

        if (!empty($pivotData))
            FacadesDB::table('activity_organization')->insert($pivotData);
    }
}
