<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buildingIds = Building::pluck('id');

        foreach ($buildingIds as $buildingId)
        {
            Organization::factory(rand(2,5))->withPhones(rand(1,3))->create([
                'building_id' => $buildingId
            ]);
        }
    }
}
