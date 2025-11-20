<?php

namespace Tests\Feature;

use App\Models\Building;
use App\Models\Organization;
use App\Models\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();
    }

    
    public function test_it_returns_organization_by_id()
    {
        $building = Building::factory()->create();
        $organization = Organization::factory()->for($building)->create();


        $response = $this->getJson("/api/organizations/{$organization->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => true,
                     'message' => 'Организация по введенному ID найдена!',
                     'data' => [
                         'id' => $organization->id,
                         'name' => $organization->name,
                     ],
                 ]);
    }

    
    public function test_it_returns_organizations_by_activity_id()
    {
        $activity = Activity::factory()->create();
        $organization = Organization::factory()->create([
            'building_id' => Building::factory(),
        ]);
        $organization->activities()->attach($activity->id);

        $payload = ['activity_id' => $activity->id];

        $response = $this->getJson('/api/organizations/activity?' . http_build_query($payload));

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => true,
                     'message' => 'Организации по введенной активности найдены!',
                 ]);
    }

    
    public function test_it_returns_organizations_by_activity_name()
    {
        $activity = Activity::factory()->create();
        $organization = Organization::factory()->create([
            'building_id' => Building::factory(),
        ]);
        $organization->activities()->attach($activity->id);

        $payload = ['activity_name' => $activity->name];

        $response = $this->getJson('/api/organizations/activity?' . http_build_query($payload));

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => true,
                     'message' => 'Организации по введенной активности найдены!',
                 ]);
    }

    
    public function test_it_returns_organizations_by_building_id()
    {
        $building = Building::factory()->create();
        $organization = Organization::factory()->for($building)->create();

        $payload = ['building_id' => $building->id];

        $response = $this->getJson('/api/organizations/building?' . http_build_query($payload));

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => true,
                     'message' => 'Организации в этом здании найдены!',
                 ]);
    }

    
    public function test_it_returns_organizations_by_building_address()
    {
        $organization = Organization::factory()->create([
            'building_id' => Building::factory(),
        ]);
        
        $addressOfBuilding = Building::find($organization->building_id)->address;

        preg_match('/(?:город\s|г\.\s)([^,]+)/iu', $addressOfBuilding, $city);

        $payload = ['address' => $city[0]];

        $response = $this->getJson('/api/organizations/building?' . http_build_query($payload));

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => true,
                     'message' => 'Организации в этом здании найдены!',
                 ]);
    }

    
    public function test_it_returns_organizations_by_name()
    {
        $organization = Organization::factory()->create([
            'name' => 'Test Organization',
            'building_id' => Building::factory(),
        ]);

        $payload = ['name' => 'Test'];

        $response = $this->getJson('/api/organizations/name?' . http_build_query($payload));

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => true,
                     'message' => 'Организация с введенным названием найдена!',
                 ]);
    }

    
    public function test_it_returns_organizations_in_geo_area_radius()
    {
        $building = Building::factory()->create();

        $organization = Organization::factory()->for($building)->create();

        $payload = [
            'latitude' => $building->location->getLatitude(),
            'longitude' => $building->location->getLongitude(),
            'radius' => 1000,
        ];

        $response = $this->postJson('/api/organizations/geo', $payload);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => true,
                     'message' => 'Организации в данной области найдены!',
                 ]);
    }
}
