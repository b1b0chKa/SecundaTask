<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\Building;
use App\Models\Organization;
use App\Services\OrganizationService;
use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected OrganizationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new OrganizationService();
    }


    public function test_get_by_building_returns_by_building_id()
    {
        $building = Building::factory()->create();
        $organization = Organization::factory()->for($building)->create();

        $result = $this->service->getByBuilding(['building_id' => $building->id]);

        $this->assertNotEmpty($result);
        $this->assertEquals($organization->id, $result->first()->id);
    }


    public function test_get_by_building_returns_by_address()
    {
        $building = Building::factory()->create(['address' => '123 Main Street']);
        $organization = Organization::factory()->for($building)->create();

        $result = $this->service->getByBuilding(['address' => 'Main Street']);

        $this->assertNotEmpty($result);
        $this->assertEquals($organization->id, $result->first()->id);
    }
    

    public function test_get_by_id_returns_organization_with_relations()
    {
        $building = Building::factory()->create();
        $organization = Organization::factory()->for($building)->create();

        $result = $this->service->getById($organization->id);

        $this->assertNotNull($result);
        $this->assertEquals($organization->id, $result->id);
        $this->assertTrue($result->relationLoaded('building'));
    }


    public function test_get_by_name_returns_collection()
    {
        $organization = Organization::factory()->create([
            'name'          => 'My Org',
            'building_id'   => Building::factory(),
        ]);

        $result = $this->service->getByName('My');

        $this->assertNotEmpty($result);
        $this->assertEquals('My Org', $result->first()->name);
    }


    public function test_get_by_activity_returns_collection()
    {
        $activity = Activity::factory()->create();
        $organization = Organization::factory()->create([
            'building_id' => Building::factory(),
        ]);
        $organization->activities()->attach($activity);

        $result = $this->service->getByActivity(['activity_id' => $activity->id]);

        $this->assertNotEmpty($result);
        $this->assertEquals($organization->id, $result->first()->id);
    }


    public function test_get_by_geo_returns_collection_by_radius()
    {
        $building = Building::factory()->create([
            'location' => Point::makeGeodetic(55.75, 37.62),
        ]);
        $organization = Organization::factory()->for($building)->create();

        $result = $this->service->getByGeo([
            'latitude' => 55.75,
            'longitude' => 37.62,
            'radius' => 10
        ]);

        $this->assertNotEmpty($result);
        $this->assertEquals($organization->id, $result->first()->id);
    }


    public function test_get_by_geo_returns_collection_by_rectangle()
    {
        $building = Building::factory()->create([
            'location' => Point::makeGeodetic(55.75, 37.62),

        ]);
        $organization = Organization::factory()->for($building)->create();

        $result = $this->service->getByGeo([
            'lat_min' => 55.70,
            'lat_max' => 55.80,
            'lng_min' => 37.60,
            'lng_max' => 37.65,
        ]);

        $this->assertNotEmpty($result);
        $this->assertEquals($organization->id, $result->first()->id);
    }


    public function test_get_by_building_returns_empty_collection_if_no_data()
    {
        $result = $this->service->getByBuilding([]);
        $this->assertEmpty($result);
    }


    public function test_get_by_activity_returns_empty_collection_if_activity_not_found()
    {
        $result = $this->service->getByActivity(['activity_id' => 999]);
        $this->assertEmpty($result);
    }

    
    public function test_get_by_geo_returns_empty_collection_if_no_coordinates()
    {
        $result = $this->service->getByGeo([]);
        $this->assertEmpty($result);
    }
}
